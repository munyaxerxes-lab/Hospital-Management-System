<?php

namespace App\Http\Controllers;

use App\Models\lab_test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabTestController extends Controller
{
    /**
     * Display all lab tests.
     */
    public function index()
    {
        $lab_tests = lab_test::latest()->get();

        return view('account.admin.lab_request', compact('lab_tests'));
    }


    /**
     * Store a new lab test.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'preparation' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $path = $request->file('image')
                ->store('lab_tests', 'public');

            $validated['image'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | New Lab Tests Are Active
        |--------------------------------------------------------------------------
        */

        $validated['status'] = true;

        lab_test::create($validated);

        return redirect()
            ->route('admin.lab_tests.index')
            ->with('success', 'Lab test added successfully.');
    }


    /**
     * Show edit page / edit form.
     */
    public function edit(lab_test $lab_test)
    {
        return view('account.admin.lab_request', compact('lab_test'));
    }


    /**
     * Update an existing lab test.
     */
    public function update(Request $request, lab_test $lab_test)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'preparation' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'      => 'required|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Replace Image If New Image Was Uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            // Delete old image
            if ($lab_test->image) {
                Storage::disk('public')->delete($lab_test->image);
            }

            // Store new image
            $path = $request->file('image')
                ->store('lab_tests', 'public');

            $validated['image'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Lab Test
        |--------------------------------------------------------------------------
        */

        $lab_test->update($validated);

        return redirect()
            ->route('admin.lab_tests.index')
            ->with('success', 'Lab test updated successfully.');
    }


    /**
     * Activate / Deactivate lab test.
     */
    public function toggleStatus($id)
    {
        $lab_test = lab_test::findOrFail($id);

        $lab_test->status = !$lab_test->status;

        $lab_test->save();

        return redirect()
            ->route('admin.lab_tests.index')
            ->with(
                'success',
                $lab_test->status
                    ? 'Lab test activated successfully.'
                    : 'Lab test deactivated successfully.'
            );
    }


    /**
     * Delete lab test.
     */
    public function destroy(lab_test $lab_test)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Image From Storage
        |--------------------------------------------------------------------------
        */

        if ($lab_test->image) {
            Storage::disk('public')->delete($lab_test->image);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Database Record
        |--------------------------------------------------------------------------
        */

        $lab_test->delete();

        return redirect()
            ->route('admin.lab_tests.index')
            ->with('success', 'Lab test deleted successfully.');
    }
}