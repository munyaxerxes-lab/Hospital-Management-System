<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Display the Manage Doctors page.
     */
    public function index()
    {
        $doctors = Doctor::latest()->get();

        return view('account.admin.manage_doctors', compact('doctors'));
    }

    /**
     * Store a newly created doctor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_name' => [
                'required',
                'string',
                'max:255',
            ],
            'specialty' => [
                'required',
                'string',
                'max:255',
                'in:Cardiology,Neurosurgery,Pharmacy,Laboratory,Pediatrics,Orthopedics,Gynecology,Neurology',
            ],
            'qualification' => [
                'required',
                'string',
                'max:255',
            ],
            'years_of_experience' => [
                'required',
                'integer',
                'min:0',
                'max:70',
            ],
            'consultation_fee' => [
                'required',
                'numeric',
                'min:0',
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:doctors,username',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:4096',
            ],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        // Create doctor
        Doctor::create($validated);

        // Return to manage doctors page
        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    /**
     * Show Edit Doctor form
     */
    public function edit(Doctor $doctor)
    {
        return view(
            'account.admin.edit_doctor',
            compact('doctor')
        );
    }

    /**
     * Update Doctor
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'doctor_name' => [
                'required',
                'string',
                'max:255',
            ],
            'specialty' => [
                'required',
                'string',
                'max:255',
                'in:Cardiology,Neurosurgery,Pharmacy,Laboratory,Pediatrics,Orthopedics,Gynecology,Neurology',
            ],
            'qualification' => [
                'required',
                'string',
                'max:255',
            ],
            'years_of_experience' => [
                'required',
                'integer',
                'min:0',
                'max:70',
            ],
            'consultation_fee' => [
                'required',
                'numeric',
                'min:0',
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:doctors,username,' . $doctor->id,
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:4096',
            ],
        ]);

        if ($request->hasFile('avatar')) {
            if ($doctor->avatar && Storage::disk('public')->exists($doctor->avatar)) {
                Storage::disk('public')->delete($doctor->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('doctors', 'public');
        }

        $doctor->update($validated);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor profile updated successfully.');
    }

    /**
     * Delete Doctor
     */
    public function destroy(Doctor $doctor)
    {
        if ($doctor->avatar && Storage::disk('public')->exists($doctor->avatar)) {
            Storage::disk('public')->delete($doctor->avatar);
        }

        $doctor->schedules()->delete();
        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor and associated schedules deleted successfully.');
    }

      /**
     * Activate or deactivate a doctor.
     */
    public function toggleStatus($id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($doctor->status === 'active') {
            $doctor->status = 'inactive';
            $message = 'Doctor deactivated successfully.';
        } else {
            $doctor->status = 'active';
            $message = 'Doctor activated successfully.';
        }

        $doctor->save();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', $message);
    }

}