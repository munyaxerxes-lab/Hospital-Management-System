<?php

namespace App\Http\Controllers;

use App\Models\appointments;
use App\Models\Doctor;
use App\Models\doctor_schedule;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display all created appointments / doctor schedules.
     */
    public function index(Request $request)
    {
        $query = doctor_schedule::with('doctor')->latest('date');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('doctor', function ($docQ) use ($search) {
                      $docQ->where('doctor_name', 'like', "%{$search}%")
                           ->orWhere('specialty', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Doctor filter
        if ($request->filled('doctor_id') && $request->doctor_id !== 'all') {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Date Range filters
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $schedules = $query->paginate(15)->withQueryString();

        $doctors = Doctor::orderBy('doctor_name')->get();
        $activeDoctors = Doctor::where('status', 'active')->orderBy('doctor_name')->get();

        $stats = [
            'total' => doctor_schedule::count(),
            'available' => doctor_schedule::where('status', 'available')->count(),
            'booked' => doctor_schedule::where('status', 'booked')->count(),
            'unavailable' => doctor_schedule::whereIn('status', ['unavailable', 'inactive'])->count(),
            'doctors_count' => Doctor::where('status', 'active')->count(),
        ];

        return view('account.admin.appointment_request', compact('schedules', 'doctors', 'activeDoctors', 'stats'));
    }

    /**
     * Show the appointment creation page.
     */
    public function create()
    {
        $doctors = Doctor::where('status', 'active')->orderBy('doctor_name')->get();

        if ($doctors->isEmpty()) {
            $doctors = Doctor::orderBy('doctor_name')->get();
        }

        return view('account.admin.create_appointment', compact('doctors'));
    }

    /**
     * Store newly created appointment schedule(s) with single date or date interval support.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'       => ['required', 'integer', 'exists:doctors,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'status'          => ['required', 'in:available,unavailable,booked,active,inactive'],
            'reason'          => ['nullable', 'string', 'max:255'],
            'schedule_mode'   => ['nullable', 'in:single,range'],
            'date'            => ['nullable', 'date'],
            'start_date'      => ['nullable', 'date'],
            'end_date'        => ['nullable', 'date', 'after_or_equal:start_date'],
            'days_of_week'    => ['nullable', 'array'],
            'days_of_week.*'  => ['string'],
            'available_hours' => ['required_without:start_time', 'array', 'min:1'],
            'available_hours.*' => ['string'],
            'start_time'      => ['nullable'],
            'end_time'        => ['nullable'],
        ], [
            'available_hours.required_without' => 'Please select at least one available hour/slot for the doctor.',
            'available_hours.min' => 'Please select at least one available hour/slot for the doctor.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
        ]);

        // Normalize status
        if ($validated['status'] === 'active') {
            $validated['status'] = 'available';
        } elseif ($validated['status'] === 'inactive') {
            $validated['status'] = 'unavailable';
        }

        // Determine start and end time from available_hours if provided
        if (!empty($request->input('available_hours')) && is_array($request->input('available_hours'))) {
            $hours = $request->input('available_hours');
            sort($hours);

            $startTime = date('H:i', strtotime($hours[0]));
            $lastTime = strtotime(end($hours));
            $endTime = date('H:i', strtotime('+30 minutes', $lastTime));
        } else {
            $startTime = date('H:i', strtotime($validated['start_time'] ?? '08:00'));
            $endTime = date('H:i', strtotime($validated['end_time'] ?? '17:00'));
        }

        $doctor = Doctor::find($validated['doctor_id']);
        $scheduleMode = $request->input('schedule_mode', 'range');

        // Check if date range is selected
        if ($scheduleMode === 'range' && !empty($validated['start_date']) && !empty($validated['end_date'])) {
            $startDate = \Carbon\Carbon::parse($validated['start_date'])->startOfDay();
            $endDate = \Carbon\Carbon::parse($validated['end_date'])->startOfDay();
            $daysOfWeek = $request->input('days_of_week', []);

            // Normalize day of week names if specified
            $allowedDays = !empty($daysOfWeek) ? array_map('strtolower', $daysOfWeek) : [];

            $createdCount = 0;
            $current = $startDate->copy();

            DB::beginTransaction();
            try {
                while ($current->lte($endDate)) {
                    $dayName = strtolower($current->format('l')); // e.g. monday
                    $shortDayName = strtolower($current->format('D')); // e.g. mon

                    // Check if current day of week is allowed (or all days if none selected)
                    $isAllowed = empty($allowedDays)
                        || in_array($dayName, $allowedDays)
                        || in_array($shortDayName, $allowedDays);

                    if ($isAllowed) {
                        doctor_schedule::updateOrCreate(
                            [
                                'doctor_id'  => $validated['doctor_id'],
                                'date'       => $current->toDateString(),
                                'start_time' => $startTime,
                            ],
                            [
                                'end_time'   => $endTime,
                                'price'      => $validated['price'],
                                'status'     => $validated['status'],
                                'reason'     => $validated['reason'] ?? 'Doctor Consultation Schedule',
                            ]
                        );
                        $createdCount++;
                    }

                    $current->addDay();
                }

                DB::commit();

                $doctorName = $doctor ? 'Dr. ' . $doctor->doctor_name : 'Doctor';
                $startFormatted = $startDate->format('d M Y');
                $endFormatted = $endDate->format('d M Y');

                return redirect()
                    ->route('admin.appointments.index')
                    ->with('success', "{$createdCount} schedule(s) successfully generated for {$doctorName} across the date interval ({$startFormatted} to {$endFormatted}).");
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Failed to generate schedules: ' . $e->getMessage());
            }
        }

        // Single Date Mode
        $singleDate = !empty($validated['date'])
            ? $validated['date']
            : (!empty($validated['start_date']) ? $validated['start_date'] : date('Y-m-d'));

        doctor_schedule::updateOrCreate(
            [
                'doctor_id'  => $validated['doctor_id'],
                'date'       => $singleDate,
                'start_time' => $startTime,
            ],
            [
                'end_time'   => $endTime,
                'price'      => $validated['price'],
                'status'     => $validated['status'],
                'reason'     => $validated['reason'] ?? 'Doctor Consultation Schedule',
            ]
        );

        $doctorName = $doctor ? 'Dr. ' . $doctor->doctor_name : 'Doctor';
        $formattedDate = date('d M Y', strtotime($singleDate));

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', "Doctor appointment schedule created successfully for {$doctorName} on {$formattedDate}.");
    }

    /**
     * Show edit appointment page.
     */
    public function edit($id)
    {
        $schedule = doctor_schedule::with('doctor')->findOrFail($id);
        $doctors = Doctor::orderBy('doctor_name')->get();

        return view('account.admin.edit_appointment', compact('schedule', 'doctors'));
    }

    /**
     * Update an appointment schedule.
     */
    public function update(Request $request, $id)
    {
        $schedule = doctor_schedule::findOrFail($id);

        $validated = $request->validate([
            'doctor_id'       => ['required', 'integer', 'exists:doctors,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'status'          => ['required', 'in:available,unavailable,booked,active,inactive'],
            'reason'          => ['nullable', 'string', 'max:255'],
            'available_hours' => ['nullable', 'array'],
            'available_hours.*' => ['string'],
            'date'            => ['nullable', 'date'],
            'start_time'      => ['nullable'],
            'end_time'        => ['nullable'],
        ]);

        // Normalize status
        if ($validated['status'] === 'active') {
            $validated['status'] = 'available';
        } elseif ($validated['status'] === 'inactive') {
            $validated['status'] = 'unavailable';
        }

        $date = !empty($validated['date']) ? $validated['date'] : ($schedule->date ?? date('Y-m-d'));

        if (!empty($request->input('available_hours')) && is_array($request->input('available_hours'))) {
            $hours = $request->input('available_hours');
            sort($hours);

            $startTime = date('H:i', strtotime($hours[0]));
            $lastTime = strtotime(end($hours));
            $endTime = date('H:i', strtotime('+30 minutes', $lastTime));
        } else {
            $startTime = date('H:i', strtotime($validated['start_time'] ?? $schedule->start_time));
            $endTime = date('H:i', strtotime($validated['end_time'] ?? $schedule->end_time));
        }

        $schedule->update([
            'doctor_id'  => $validated['doctor_id'],
            'date'       => $date,
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'price'      => $validated['price'],
            'status'     => $validated['status'],
            'reason'     => $validated['reason'] ?? $schedule->reason,
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment schedule updated successfully.');
    }

    /**
     * Toggle status (available / unavailable).
     */
    public function toggleStatus($id)
    {
        $schedule = doctor_schedule::findOrFail($id);

        if ($schedule->status === 'available' || $schedule->status === 'active') {
            $schedule->status = 'unavailable';
            $message = 'Appointment marked as unavailable.';
        } else {
            $schedule->status = 'available';
            $message = 'Appointment marked as available.';
        }

        $schedule->save();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', $message);
    }

    /**
     * Delete an appointment schedule.
     */
    public function destroy($id)
    {
        $schedule = doctor_schedule::findOrFail($id);
        $schedule->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Handle patient appointment booking from the Doctors List page.
     */
    public function storePatientAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'   => ['required', 'integer', 'exists:doctors,id'],
            'schedule_id' => ['required', 'integer', 'exists:doctor_schedule,id'],
            'reason'      => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please log in first.'], 401);
        }

        $patient = Patient::firstOrCreate(['user_id' => $user->id]);

        $schedule = doctor_schedule::findOrFail($validated['schedule_id']);

        if ($schedule->status !== 'available') {
            return response()->json(['success' => false, 'message' => 'This slot is no longer available. Please choose another.'], 409);
        }

        DB::beginTransaction();
        try {
            $appointment = appointments::create([
                'patient_id'  => $patient->id,
                'doctor_id'   => $validated['doctor_id'],
                'schedule_id' => $validated['schedule_id'],
                'reason'      => $validated['reason'] ?? 'General Consultation',
                'status'      => 'confirmed',
            ]);

            // Mark the slot as booked so others can't take it
            $schedule->status = 'booked';
            $schedule->save();

            DB::commit();

            $doctor = Doctor::find($validated['doctor_id']);

            return response()->json([
                'success'        => true,
                'message'        => 'Appointment booked successfully!',
                'appointment_id' => $appointment->id,
                'doctor_name'    => $doctor->doctor_name ?? 'Doctor',
                'date'           => $schedule->date?->format('d M Y'),
                'time'           => $schedule->start_time,
                'fee'            => number_format($schedule->price, 0, '.', ' ') . ' FCFA',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Booking failed: ' . $e->getMessage()], 500);
        }
    }
}
