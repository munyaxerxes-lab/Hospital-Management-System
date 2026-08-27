<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\doctor_schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display all created appointments / doctor schedules.
     */
    public function index(Request $request)
    {
        $query = doctor_schedule::with('doctor')->latest();

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
     * Store a newly created appointment / schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'       => ['required', 'integer', 'exists:doctors,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'status'          => ['required', 'in:available,unavailable,booked,active,inactive'],
            'reason'          => ['nullable', 'string', 'max:255'],
            'available_hours' => ['required_without:start_time', 'array', 'min:1'],
            'available_hours.*' => ['string'],
            'date'            => ['nullable', 'date'],
            'start_time'      => ['nullable'],
            'end_time'        => ['nullable'],
        ], [
            'available_hours.required_without' => 'Please select at least one available hour/slot for the doctor.',
            'available_hours.min' => 'Please select at least one available hour/slot for the doctor.',
        ]);

        // Normalize status
        if ($validated['status'] === 'active') {
            $validated['status'] = 'available';
        } elseif ($validated['status'] === 'inactive') {
            $validated['status'] = 'unavailable';
        }

        // Determine date
        $date = !empty($validated['date']) ? $validated['date'] : date('Y-m-d');

        // Determine start and end time from available_hours if provided
        if (!empty($request->input('available_hours')) && is_array($request->input('available_hours'))) {
            $hours = $request->input('available_hours');
            sort($hours);

            $startTime = date('H:i', strtotime($hours[0]));
            // End time is last slot + 30 mins
            $lastTime = strtotime(end($hours));
            $endTime = date('H:i', strtotime('+30 minutes', $lastTime));
        } else {
            $startTime = date('H:i', strtotime($validated['start_time'] ?? '08:00'));
            $endTime = date('H:i', strtotime($validated['end_time'] ?? '17:00'));
        }

        doctor_schedule::create([
            'doctor_id'  => $validated['doctor_id'],
            'date'       => $date,
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'price'      => $validated['price'],
            'status'     => $validated['status'],
            'reason'     => $validated['reason'] ?? 'Doctor Consultation Schedule',
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Doctor appointment schedule created successfully.');
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
}
