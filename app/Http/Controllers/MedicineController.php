<?php

namespace App\Http\Controllers;

use App\Models\Medicine; // Ensure capitalization matches your actual class filename
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->get();
        return view('account.admin.medicine_orders', compact('medicines'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'type'        => 'required|string|in:Capsules,Tablets,Syrup,Powder,Band,Injection,Cotton,Drips',
        'stock'       => 'required|integer|min:0',
        'expiry_date' => 'required|date',
        'price'       => 'required|numeric|min:0',
        'description' => 'nullable|string|max:1000',
        'status'      => 'required|in:1,0', 
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);
       // Handle Image Upload
    if ($request->hasFile('image')) {
        // Saves to storage/app/public/medicines and returns path name
        $path = $request->file('image')->store('medicines', 'public');
        $validated['image'] = $path;
    }


    // Convert string status to boolean
    $validated['status'] = (bool) $validated['status'];

 

    \App\Models\Medicine::create($validated);

    return redirect()
        ->route('admin.medicines.index')
        ->with('success', 'Medicine added successfully.');
}


    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|in:Capsules,Tablets,Syrup,Powder,Band,Injection,Cotton,Drips',
            'stock'       => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'status'      => 'required|boolean',
        ]);

        $medicine->update($validated);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine details updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->status = !$medicine->status; // Toggle boolean state safely
        $medicine->save();

        return redirect()->route('admin.medicines.index')->with('success', 'Status updated successfully.');
    }
}
