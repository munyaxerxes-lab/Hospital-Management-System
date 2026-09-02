<?php

namespace App\Http\Controllers;

use App\Models\lab_test;
use App\Models\LabRequest;
use App\Models\lab_request_items;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\LabRequestConfirmationMail;

class LabTestController extends Controller
{
    /**
     * Display lab tests catalog and patient lab requests with stats and filters.
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'catalog');

        /*
        |--------------------------------------------------------------------------
        | 1. Query Available Lab Tests (Catalog)
        |--------------------------------------------------------------------------
        */
        $testQuery = lab_test::query();

        if ($request->filled('search')) {
            $searchTerm = trim($request->query('search'));
            $testQuery->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('category', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category') && $request->query('category') !== 'all') {
            $testQuery->where('category', $request->query('category'));
        }

        if ($request->filled('status') && $request->query('status') !== 'all') {
            $testQuery->where('status', (bool)$request->query('status'));
        }

        $lab_tests = $testQuery->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | 2. Query Patient Lab Requests (From DB)
        |--------------------------------------------------------------------------
        */
        $requestQuery = LabRequest::with(['user', 'patient.user', 'items.test']);

        if ($request->filled('request_search')) {
            $search = trim($request->query('request_search'));
            $requestQuery->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('items', function ($iq) use ($search) {
                      $iq->where('test_name', 'like', "%{$search}%")
                         ->orWhereHas('test', function ($tq) use ($search) {
                             $tq->where('name', 'like', "%{$search}%");
                         });
                  });
            });
        }

        if ($request->filled('request_status') && $request->query('request_status') !== 'all') {
            $statusFilter = $request->query('request_status');
            if ($statusFilter === 'delivered') {
                $requestQuery->whereIn('status', ['delivered', 'completed']);
            } else {
                $requestQuery->where('status', $statusFilter);
            }
        }

        $lab_requests = $requestQuery->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | 3. Compute Real-time Dashboard Statistics
        |--------------------------------------------------------------------------
        */
        $stats = [
            'total_requests' => LabRequest::count(),
            'delivered'      => LabRequest::whereIn('status', ['delivered', 'completed'])->count(),
            'pending'        => LabRequest::where('status', 'pending')->count(),
            'processing'     => LabRequest::whereIn('status', ['processing', 'sample_collected'])->count(),
            'total_tests'    => lab_test::count(),
        ];

        // Unique categories for filter dropdown
        $categories = lab_test::select('category')->distinct()->pluck('category')->filter()->values();

        return view('account.admin.lab_request', compact('lab_tests', 'lab_requests', 'stats', 'categories', 'activeTab'));
    }


    /**
     * Store a new lab test into the catalog.
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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lab_tests', 'public');
            $validated['image'] = $path;
        }

        $validated['status'] = true;

        lab_test::create($validated);

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'catalog'])
            ->with('success', 'Lab test added successfully to catalog.');
    }


    /**
     * Show the form for editing the specified lab test.
     */
    public function edit(lab_test $lab_test)
    {
        return view('account.admin.edit_lab_test', compact('lab_test'));
    }

    /**
     * Update an existing lab test in catalog.
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

        if ($request->hasFile('image')) {
            if ($lab_test->image) {
                Storage::disk('public')->delete($lab_test->image);
            }
            $path = $request->file('image')->store('lab_tests', 'public');
            $validated['image'] = $path;
        }

        $lab_test->update($validated);

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'catalog'])
            ->with('success', 'Lab test updated successfully.');
    }


    /**
     * Activate / Deactivate lab test availability.
     */
    public function toggleStatus($id)
    {
        $lab_test = lab_test::findOrFail($id);
        $lab_test->status = !$lab_test->status;
        $lab_test->save();

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'catalog'])
            ->with(
                'success',
                $lab_test->status
                    ? 'Lab test activated successfully.'
                    : 'Lab test paused / deactivated successfully.'
            );
    }


    /**
     * Delete lab test from catalog.
     */
    public function destroy(lab_test $lab_test)
    {
        if ($lab_test->image) {
            Storage::disk('public')->delete($lab_test->image);
        }

        $lab_test->delete();

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'catalog'])
            ->with('success', 'Lab test deleted successfully.');
    }


    /**
     * Update status of a patient lab request (e.g. Delivered, Pending, Processing).
     */
    public function updateRequestStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,sample_collected,processing,delivered,completed,cancelled',
        ]);

        $labRequest = LabRequest::findOrFail($id);
        $labRequest->status = $validated['status'];

        if (in_array($validated['status'], ['delivered', 'completed'])) {
            $labRequest->delivered_at = now();
        } elseif ($validated['status'] === 'pending') {
            $labRequest->delivered_at = null;
        }

        $labRequest->save();

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'requests'])
            ->with('success', "Lab request status updated to {$validated['status']}.");
    }


    /**
     * Upload test result document (Word, PDF, Image) and attach diagnostic findings.
     */
    public function uploadResult(Request $request, $id)
    {
        $validated = $request->validate([
            'result_file'  => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg,webp|max:10240', // 10MB max
            'result_notes' => 'nullable|string|max:2000',
            'mark_delivered' => 'nullable|boolean',
        ]);

        $labRequest = LabRequest::findOrFail($id);

        if ($request->hasFile('result_file')) {
            $file = $request->file('result_file');
            $extension = strtolower($file->getClientOriginalExtension());
            $originalName = $file->getClientOriginalName();

            // Delete previous result document if exists
            if ($labRequest->result_document) {
                Storage::disk('public')->delete($labRequest->result_document);
            }

            // Determine file type category
            if ($extension === 'pdf') {
                $fileType = 'pdf';
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $fileType = 'word';
            } else {
                $fileType = 'image';
            }

            $storedPath = $file->store('lab_results', 'public');

            $labRequest->result_document = $storedPath;
            $labRequest->result_file_name = $originalName;
            $labRequest->result_file_type = $fileType;
            $labRequest->result_notes = $validated['result_notes'] ?? null;
            $labRequest->result_uploaded_at = now();
            $labRequest->status = 'delivered';
            $labRequest->delivered_at = now();
            $labRequest->save();
        }

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'requests'])
            ->with('success', 'Lab test result document uploaded and request marked as Delivered / Completed.');
    }


    /**
     * Download or view the uploaded lab result document.
     */
    public function downloadResult($id)
    {
        $labRequest = LabRequest::findOrFail($id);

        if (!$labRequest->result_document || !Storage::disk('public')->exists($labRequest->result_document)) {
            return back()->with('error', 'Result file not found or has been removed.');
        }

        return Storage::disk('public')->download(
            $labRequest->result_document,
            $labRequest->result_file_name ?? 'lab_result_' . $labRequest->request_number . '.' . pathinfo($labRequest->result_document, PATHINFO_EXTENSION)
        );
    }


    /**
     * Delete a patient lab request.
     */
    public function deleteRequest($id)
    {
        $labRequest = LabRequest::findOrFail($id);

        if ($labRequest->result_document) {
            Storage::disk('public')->delete($labRequest->result_document);
        }

        $labRequest->items()->delete();
        $labRequest->delete();

        return redirect()
            ->route('admin.lab_tests.index', ['tab' => 'requests'])
            ->with('success', 'Lab request deleted successfully.');
    }


    /**
     * Handle patient lab test request booking / checkout.
     */
    public function storePatientRequest(Request $request)
    {
        $validated = $request->validate([
            'test_ids'        => 'nullable|array',
            'test_ids.*'      => 'exists:lab_tests,id',
            'address'         => 'nullable|string|max:500',
            'scheduled_date'  => 'nullable|string|max:50',
            'visit_date'      => 'nullable|string|max:50',
            'scheduled_time'  => 'nullable|string|max:50',
            'visit_time'      => 'nullable|string|max:50',
            'notes'           => 'nullable|string|max:1000',
            'payment_method'  => 'nullable|string|max:50',
        ]);

        $user = Auth::user();
        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Please log in to book a lab test.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to book a lab test.');
        }

        $patient = Patient::firstOrCreate(['user_id' => $user->id]);

        $testIds = $validated['test_ids'] ?? [];
        if (empty($testIds)) {
            $testIds = lab_test::where('status', true)->take(3)->pluck('id')->toArray();
            if (empty($testIds)) {
                $defaultTest = lab_test::firstOrCreate(
                    ['name' => 'General Diagnostic Screening'],
                    ['category' => 'General', 'price' => 5000, 'description' => 'Comprehensive health panel', 'status' => true]
                );
                $testIds = [$defaultTest->id];
            }
        }

        $selectedTests = lab_test::whereIn('id', $testIds)->get();
        $totalAmount = $selectedTests->sum('price');
        if ($totalAmount <= 0) {
            $totalAmount = 8000;
        }

        $requestNumber = 'LAB-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $date = !empty($validated['scheduled_date']) ? $validated['scheduled_date'] : ($validated['visit_date'] ?? now()->addDay()->toDateString());
        $time = !empty($validated['scheduled_time']) ? $validated['scheduled_time'] : ($validated['visit_time'] ?? '09:00 AM');

        DB::beginTransaction();
        try {
            $labRequest = LabRequest::create([
                'request_number' => $requestNumber,
                'user_id'        => $user->id,
                'patient_id'     => $patient->id,
                'total_amount'   => $totalAmount,
                'status'         => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'] ?? 'cash_on_delivery',
                'sample_type'    => 'Blood / Standard Sample',
                'scheduled_date' => date('Y-m-d', strtotime($date)),
                'scheduled_time' => $time,
                'address'        => $validated['address'] ?? 'Hospital Laboratory Department',
                'notes'          => $validated['notes'] ?? null,
            ]);

            foreach ($selectedTests as $test) {
                lab_request_items::create([
                    'lab_request_id' => $labRequest->id,
                    'lab_test_id'    => $test->id,
                    'test_name'      => $test->name,
                    'price'          => $test->price,
                ]);
            }

            DB::commit();

            // Load relationships for email
            $labRequest->load(['user', 'patient.user', 'items.test']);

            // Send confirmation emails (fault-tolerant)
            try {
                // 1. Send confirmation to patient
                if (!empty($user->email)) {
                    Mail::to($user->email)->send(new LabRequestConfirmationMail($labRequest, 'patient'));
                }

                // 2. Send notification to admins
                $adminEmails = User::whereHas('role', function ($q) {
                    $q->where('name', 'admin')->orWhere('name', 'Admin');
                })->pluck('email')->filter()->unique()->toArray();

                if (!empty($adminEmails)) {
                    Mail::to($adminEmails)->send(new LabRequestConfirmationMail($labRequest, 'admin'));
                }
            } catch (\Throwable $mailEx) {
                Log::warning('Lab request confirmation email could not be sent: ' . $mailEx->getMessage(), [
                    'lab_request_id' => $labRequest->id,
                ]);
            }

            $msg = "Lab test request #{$requestNumber} submitted successfully! Total: " . number_format($totalAmount, 0, '.', ' ') . " FCFA. Our lab technicians will attend to your request.";

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'request_number' => $requestNumber,
                    'lab_request_id' => $labRequest->id,
                ]);
            }

            return back()->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Failed to submit lab request. Error: ' . $e->getMessage());
        }
    }
}