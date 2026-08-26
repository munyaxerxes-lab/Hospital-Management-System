<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

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
                'unique:doctor,username',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

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
                'regex:/^[A-ZÀ-ÖØ-Þ][a-zà-öø-ÿ]+(?:[ -][A-ZÀ-ÖØ-Þ][a-zà-öø-ÿ]+)*$/u',
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
                'regex:/^[a-z0-9._]+$/',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);


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
        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
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