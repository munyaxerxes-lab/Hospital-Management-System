@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 50px;">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;margin-bottom:20px;">
        <div>
            <h1 class="page-title">Laboratory & Test Requests</h1>
            <p class="page-subtitle" style="margin-bottom:0;">
                Manage available lab tests, track patient test requests in real-time, and upload diagnostic result documents (Word, PDF, Images).
            </p>
        </div>

        <div style="display:flex;gap:10px;align-items:center;">
            <button popovertarget="create-labtest-modal" class="open-btn" style="display:inline-flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-plus"></i> Add New Lab Test
            </button>
        </div>
    </div>

    <!-- =====================================================
         FLASH NOTIFICATIONS (SUCCESS / ERROR)
    ====================================================== -->
    @if(session('success'))
        <div class="alert alert-success" id="success-message" style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:10px;background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;margin-bottom:20px;font-weight:500;">
            <i class="fa-solid fa-circle-check" style="color:#059669;font-size:18px;"></i>
            <span>{{ session('success') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3500);
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="error-message" style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;margin-bottom:20px;font-weight:500;">
            <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;font-size:18px;"></i>
            <span>{{ session('error') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const msg = document.getElementById('error-message');
                if (msg) {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <!-- =====================================================
         STATISTICS CARDS (APPOINTMENT PAGE DESIGN)
    ====================================================== -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
        
        <!-- Total Ordered / Requests Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-flask-vial"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Total Lab Requests</span>
                <strong style="font-size:22px;color:#1e293b;font-weight:700;">{{ $stats['total_requests'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Delivered / Completed Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Delivered / Completed</span>
                <strong style="font-size:22px;color:#059669;font-weight:700;">{{ $stats['delivered'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Pending Tests Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#fffbeb;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Pending Requests</span>
                <strong style="font-size:22px;color:#d97706;font-weight:700;">{{ $stats['pending'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Available Lab Tests in Catalog -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#faf5ff;color:#7e22ce;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-microscope"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Available Lab Tests</span>
                <strong style="font-size:22px;color:#7e22ce;font-weight:700;">{{ $stats['total_tests'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- In Progress / Processing Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#fff7ed;color:#ea580c;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-vial-virus"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">In Analysis / Progress</span>
                <strong style="font-size:22px;color:#ea580c;font-weight:700;">{{ $stats['processing'] ?? 0 }}</strong>
            </div>
        </div>

    </div>

    <!-- =====================================================
         TAB NAVIGATION
    ====================================================== -->
    @php
        $currentTab = request('tab', $activeTab ?? 'catalog');
    @endphp

    <div style="display:flex;gap:10px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        
        <a href="{{ route('admin.lab_tests.index', array_merge(request()->except('tab'), ['tab' => 'catalog'])) }}"
           style="display:inline-flex;align-items:center;gap:10px;padding:12px 20px;font-size:14.5px;font-weight:700;text-decoration:none;border-radius:8px 8px 0 0;position:relative;bottom:-2px;transition:all 0.2s;{{ $currentTab === 'catalog' ? 'color:#2563eb;border-bottom:3px solid #2563eb;background:#ffffff;' : 'color:#64748b;background:transparent;' }}">
            <i class="fa-solid fa-vials"></i>
            <span>Lab Tests Catalog</span>
            <span style="background:{{ $currentTab === 'catalog' ? '#eff6ff' : '#f1f5f9' }};color:{{ $currentTab === 'catalog' ? '#2563eb' : '#64748b' }};font-size:12px;font-weight:700;padding:2px 8px;border-radius:12px;">
                {{ $lab_tests->count() }}
            </span>
        </a>

        <a href="{{ route('admin.lab_tests.index', array_merge(request()->except('tab'), ['tab' => 'requests'])) }}"
           style="display:inline-flex;align-items:center;gap:10px;padding:12px 20px;font-size:14.5px;font-weight:700;text-decoration:none;border-radius:8px 8px 0 0;position:relative;bottom:-2px;transition:all 0.2s;{{ $currentTab === 'requests' ? 'color:#2563eb;border-bottom:3px solid #2563eb;background:#ffffff;' : 'color:#64748b;background:transparent;' }}">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Total Lab Requests (Patient Bookings)</span>
            <span style="background:{{ $currentTab === 'requests' ? '#eff6ff' : '#f1f5f9' }};color:{{ $currentTab === 'requests' ? '#2563eb' : '#64748b' }};font-size:12px;font-weight:700;padding:2px 8px;border-radius:12px;">
                {{ $lab_requests->count() }}
            </span>
        </a>

    </div>

    <!-- =====================================================
         TAB 1: AVAILABLE LAB TESTS CATALOG
    ====================================================== -->
    @if($currentTab === 'catalog')

        <!-- Catalog Filters Bar -->
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
            
            <form method="GET" action="{{ route('admin.lab_tests.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
                <input type="hidden" name="tab" value="catalog">

                <!-- Search Input -->
                <div style="position:relative;">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search test name, category..."
                        style="padding:10px 14px 10px 36px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;width:260px;background:#ffffff;"
                    >
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                </div>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Test Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Availability</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active / Available</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Paused / Unavailable</option>
                </select>

                <!-- Clear Filters Button -->
                @if(request()->hasAny(['search', 'category', 'status']) && (request('search') || request('category') !== 'all' || request('status') !== 'all'))
                    <a href="{{ route('admin.lab_tests.index', ['tab' => 'catalog']) }}" style="color:#ef4444;font-size:13px;text-decoration:none;font-weight:600;padding:8px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                        <i class="fa-solid fa-xmark"></i> Clear Filters
                    </a>
                @endif
            </form>

        </div>

        <!-- Catalog Data Table -->
        <div class="doctors-layout">
            <div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:70px;">Image</th>
                            <th>Lab Test Name</th>
                            <th>Category</th>
                            <th>Price (FCFA)</th>
                            <th>Preparation / Notes</th>
                            <th>Status</th>
                            <th style="text-align:center;width:140px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lab_tests as $test)
                            <tr>
                                <!-- Image -->
                                <td>
                                    @if($test->image)
                                        <img src="{{ asset('storage/' . $test->image) }}" alt="{{ $test->name }}"
                                             style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                                    @else
                                        <div style="width:44px;height:44px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#2563eb;border:1px solid #dbeafe;">
                                            <i class="fa-solid fa-vial"></i>
                                        </div>
                                    @endif
                                </td>

                                <!-- Name & Description -->
                                <td>
                                    <div style="font-weight:700;color:#1e293b;font-size:14.5px;">{{ $test->name }}</div>
                                    @if($test->description)
                                        <div style="font-size:12px;color:#64748b;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $test->description }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Category -->
                                <td>
                                    <span style="background:#eff6ff;color:#1d4ed8;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;border:1px solid #bfdbfe;">
                                        {{ $test->category }}
                                    </span>
                                </td>

                                <!-- Price -->
                                <td>
                                    <strong style="color:#059669;font-size:14px;font-weight:800;">
                                        {{ number_format($test->price, 0, '.', ' ') }} FCFA
                                    </strong>
                                </td>

                                <!-- Preparation -->
                                <td>
                                    @if($test->preparation)
                                        <span style="font-size:12.5px;color:#475569;max-width:220px;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $test->preparation }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;font-size:12px;">Standard Procedure</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td>
                                    @if($test->status)
                                        <span style="background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;padding:4px 10px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span> Active
                                        </span>
                                    @else
                                        <span style="background:#f1f5f9;color:#64748b;border:1px solid #cbd5e1;padding:4px 10px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span> Paused
                                        </span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="actions-cell" style="text-align:center;">
                                    <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                        <!-- Edit -->
                                        <button type="button" class="icon-btn orange" popovertarget="edit-test-{{ $test->id }}" title="Edit Lab Test">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- Toggle Status -->
                                        <form method="POST" action="{{ route('admin.lab_tests.toggleStatus', $test->id) }}" style="display:inline;margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn {{ $test->status ? 'red' : 'green' }}" title="{{ $test->status ? 'Pause availability' : 'Activate test' }}">
                                                <i class="fa-solid {{ $test->status ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <button type="button" class="icon-btn red" popovertarget="delete-test-{{ $test->id }}" title="Delete Lab Test">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:36px;color:#64748b;">
                                    <i class="fa-solid fa-vial-circle-check" style="font-size:32px;color:#cbd5e1;display:block;margin-bottom:10px;"></i>
                                    No laboratory tests found matching your search.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination" style="margin-top:16px;">
                    <span style="color:#64748b;font-size:13px;font-weight:600;">
                        Showing {{ $lab_tests->count() }} test(s)
                    </span>
                </div>
            </div>
        </div>

        <!-- =====================================================
             CATALOG MODALS (PLACED OUTSIDE TABLE)
        ====================================================== -->
        @foreach($lab_tests as $test)
            <!-- Edit Test Modal -->
            <div id="edit-test-{{ $test->id }}" popover class="modal-box">
                <div class="modal-content" style="max-width:620px;">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Lab Test Details</h3>
                        <button type="button" popovertarget="edit-test-{{ $test->id }}" popovertargetaction="hide" class="modal-close-x">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.lab_tests.update', $test->id) }}" enctype="multipart/form-data" class="doctor-form">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="form-grid">
                                <!-- Image -->
                                <div class="field full">
                                    <label>Test Illustration Image</label>
                                    <input type="file" name="image" accept="image/*" style="border:1px dashed #cbd5e1;padding:8px;width:100%;border-radius:6px;">
                                    @if($test->image)
                                        <div style="margin-top:6px;display:flex;align-items:center;gap:8px;font-size:12px;color:#64748b;">
                                            <span>Current:</span>
                                            <img src="{{ asset('storage/' . $test->image) }}" style="width:34px;height:34px;border-radius:6px;object-fit:cover;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Name -->
                                <div class="field full">
                                    <label>Test Name *</label>
                                    <input type="text" name="name" value="{{ $test->name }}" required>
                                </div>

                                <!-- Category -->
                                <div class="field">
                                    <label>Category *</label>
                                    <input type="text" name="category" value="{{ $test->category }}" required placeholder="e.g. Hematology, Microbiology">
                                </div>

                                <!-- Price -->
                                <div class="field">
                                    <label>Price (FCFA) *</label>
                                    <input type="number" name="price" value="{{ (int)$test->price }}" min="0" step="1" required>
                                </div>

                                <!-- Preparation -->
                                <div class="field full">
                                    <label>Patient Preparation / Sample Requirements</label>
                                    <input type="text" name="preparation" value="{{ $test->preparation }}" placeholder="e.g. Fasting required for 8 hours, Morning urine sample">
                                </div>

                                <!-- Description -->
                                <div class="field full">
                                    <label>Test Description & Diagnostic Scope</label>
                                    <textarea name="description" rows="3">{{ $test->description }}</textarea>
                                </div>

                                <!-- Status -->
                                <div class="field full">
                                    <label>Availability Status *</label>
                                    <select name="status" required>
                                        <option value="1" {{ $test->status ? 'selected' : '' }}>Active & Available for Booking</option>
                                        <option value="0" {{ !$test->status ? 'selected' : '' }}>Paused / Unavailable</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" popovertarget="edit-test-{{ $test->id }}" popovertargetaction="hide" class="close-btn">Cancel</button>
                            <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Update Lab Test</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Test Modal -->
            <div id="delete-test-{{ $test->id }}" popover class="alert-modal-box">
                <div class="alert-modal-content">
                    <div class="alert-modal-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="alert-modal-title">Delete Lab Test</h3>
                    <p class="alert-modal-desc">
                        Are you sure you want to remove <strong>{{ $test->name }}</strong> from the laboratory test catalog?
                    </p>
                    <div class="alert-modal-box-warning">
                        <strong>Warning:</strong> Patients will no longer be able to book this test.
                    </div>
                    <div class="alert-modal-actions">
                        <button type="button" popovertarget="delete-test-{{ $test->id }}" popovertargetaction="hide" class="btn-modal-cancel">Cancel</button>
                        <form method="POST" action="{{ route('admin.lab_tests.delete', $test->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modal-danger">
                                <i class="fa-solid fa-trash"></i> Yes, Delete Test
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    <!-- =====================================================
         TAB 2: TOTAL LAB REQUESTS (FROM PATIENTS IN DB)
    ====================================================== -->
    @else

        <!-- Requests Filters Bar -->
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
            
            <form method="GET" action="{{ route('admin.lab_tests.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
                <input type="hidden" name="tab" value="requests">

                <!-- Search Input -->
                <div style="position:relative;">
                    <input
                        type="text"
                        name="request_search"
                        value="{{ request('request_search') }}"
                        placeholder="Search request #, patient, test..."
                        style="padding:10px 14px 10px 36px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;width:280px;background:#ffffff;"
                    >
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                </div>

                <!-- Status Filter -->
                <select name="request_status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Request Statuses</option>
                    <option value="pending" {{ request('request_status') === 'pending' ? 'selected' : '' }}>⏳ Pending Sample / Review</option>
                    <option value="processing" {{ request('request_status') === 'processing' ? 'selected' : '' }}>🔄 In Analysis / Processing</option>
                    <option value="delivered" {{ request('request_status') === 'delivered' ? 'selected' : '' }}>✅ Delivered / Completed</option>
                    <option value="cancelled" {{ request('request_status') === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>

                <!-- Clear Filters Button -->
                @if(request()->hasAny(['request_search', 'request_status']) && (request('request_search') || request('request_status') !== 'all'))
                    <a href="{{ route('admin.lab_tests.index', ['tab' => 'requests']) }}" style="color:#ef4444;font-size:13px;text-decoration:none;font-weight:600;padding:8px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                        <i class="fa-solid fa-xmark"></i> Clear Filters
                    </a>
                @endif
            </form>

        </div>

        <!-- Requests Data Table (Cleanly Structured) -->
        <div class="doctors-layout">
            <div>
                <table class="data-table" style="table-layout: auto;">
                    <thead>
                        <tr>
                            <th style="width:140px;">Request #</th>
                            <th style="min-width:180px;">Patient Details</th>
                            <th style="min-width:200px;">Tests Requested</th>
                            <th style="width:130px;">Total Bill</th>
                            <th style="width:130px;">Date Scheduled</th>
                            <th style="width:120px;text-align:center;">Status</th>
                            <th style="width:140px;text-align:center;">Result Doc</th>
                            <th style="width:230px;text-align:center;">Fulfillment Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lab_requests as $req)
                            @php
                                $patientName = $req->user->name ?? ($req->patient->user->name ?? 'Walk-in Patient');
                                $patientEmail = $req->user->email ?? ($req->patient->user->email ?? 'N/A');
                            @endphp
                            <tr>
                                <!-- Request Number -->
                                <td>
                                    <span style="display:inline-flex;align-items:center;gap:5px;background:#eff6ff;color:#1d4ed8;padding:4px 8px;border-radius:6px;font-family:monospace;font-size:12.5px;font-weight:700;border:1px solid #dbeafe;">
                                        <i class="fa-solid fa-file-waveform" style="font-size:11px;"></i>
                                        {{ $req->request_number ?? ('#' . $req->id) }}
                                    </span>
                                </td>

                                <!-- Patient Name & Contact -->
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);color:#ffffff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;">
                                            {{ strtoupper(substr($patientName, 0, 2)) }}
                                        </div>
                                        <div style="overflow:hidden;">
                                            <div style="font-weight:700;color:#1e293b;font-size:13.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                {{ $patientName }}
                                            </div>
                                            <div style="font-size:11.5px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                {{ $patientEmail }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tests Requested -->
                                <td>
                                    <div style="display:flex;flex-wrap:wrap;gap:5px;">
                                        @foreach($req->items->take(2) as $item)
                                            <span style="background:#f8fafc;border:1px solid #e2e8f0;padding:3px 8px;border-radius:6px;font-size:12px;color:#334155;display:inline-flex;align-items:center;gap:5px;">
                                                <i class="fa-solid fa-flask" style="color:#2563eb;font-size:11px;"></i>
                                                {{ $item->test_name ?? ($item->test->name ?? 'Lab Test') }}
                                            </span>
                                        @endforeach
                                        @if($req->items->count() > 2)
                                            <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:3px 8px;border-radius:6px;font-size:11.5px;font-weight:700;">
                                                +{{ $req->items->count() - 2 }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Total Amount -->
                                <td>
                                    <strong style="color:#059669;font-size:14.5px;font-weight:800;">
                                        {{ number_format($req->total_amount, 0, '.', ' ') }} FCFA
                                    </strong>
                                </td>

                                <!-- Scheduled Date -->
                                <td>
                                    <div style="font-size:13px;color:#1e293b;font-weight:600;white-space:nowrap;">
                                        {{ $req->scheduled_date ? \Carbon\Carbon::parse($req->scheduled_date)->format('M d, Y') : ($req->created_at ? $req->created_at->format('M d, Y') : 'N/A') }}
                                    </div>
                                    <div style="font-size:11px;color:#64748b;">
                                        {{ $req->scheduled_time ?? '09:00 AM' }}
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td style="text-align:center;">
                                    @if(in_array($req->status, ['delivered', 'completed']))
                                        <span style="background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-circle-check" style="color:#10b981;font-size:12px;"></i> Delivered
                                        </span>
                                    @elseif($req->status === 'pending')
                                        <span style="background:#fffbeb;color:#92400e;border:1px solid #fde68a;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-clock" style="color:#f59e0b;font-size:12px;"></i> Pending
                                        </span>
                                    @elseif(in_array($req->status, ['processing', 'sample_collected']))
                                        <span style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-spinner fa-spin" style="color:#3b82f6;font-size:12px;"></i> Processing
                                        </span>
                                    @else
                                        <span style="background:#fef2f2;color:#991b1b;border:1px solid #fecaca;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-ban" style="color:#ef4444;font-size:12px;"></i> Cancelled
                                        </span>
                                    @endif
                                </td>

                                <!-- Result Document Badge -->
                                <td style="text-align:center;">
                                    @if($req->result_document)
                                        <a href="{{ route('admin.lab_requests.downloadResult', $req->id) }}"
                                           style="display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;text-decoration:none;{{ $req->result_file_type === 'pdf' ? 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;' : ($req->result_file_type === 'word' ? 'background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;' : 'background:#faf5ff;color:#7e22ce;border:1px solid #e9d5ff;') }}"
                                           title="Download/View Result Document ({{ $req->result_file_name }})">
                                            @if($req->result_file_type === 'pdf')
                                                <i class="fa-solid fa-file-pdf"></i> PDF Result
                                            @elseif($req->result_file_type === 'word')
                                                <i class="fa-solid fa-file-word"></i> Word Result
                                            @else
                                                <i class="fa-solid fa-file-image"></i> Image Result
                                            @endif
                                        </a>
                                    @else
                                        <span style="color:#94a3b8;font-size:11.5px;font-style:italic;">
                                            <i class="fa-solid fa-clock-rotate-left"></i> Awaiting Upload
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="actions-cell" style="text-align:center;">
                                    <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;flex-wrap:wrap;">
                                        
                                        <!-- Action: Upload Result Modal Trigger -->
                                        <button type="button" class="icon-btn blue" popovertarget="upload-result-{{ $req->id }}" title="Upload Test Result (Word / PDF / Image)" style="background:#3b82f6;color:#ffffff;">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </button>

                                        <!-- Action: Mark Delivered / Completed -->
                                        @if(!in_array($req->status, ['delivered', 'completed']))
                                            <form method="POST" action="{{ route('admin.lab_requests.updateStatus', $req->id) }}" style="display:inline;margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" style="background:#10b981;color:#ffffff;border:none;padding:6px 10px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:all 0.15s;" title="Mark as Delivered / Completed">
                                                    <i class="fa-solid fa-check"></i> Delivered
                                                </button>
                                            </form>
                                        @else
                                            <!-- Action: Revert to Pending -->
                                            <form method="POST" action="{{ route('admin.lab_requests.updateStatus', $req->id) }}" style="display:inline;margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" style="background:#f59e0b;color:#ffffff;border:none;padding:6px 10px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:all 0.15s;" title="Revert to Pending">
                                                    <i class="fa-solid fa-rotate-left"></i> Pending
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Action: View Details Modal Trigger -->
                                        <button type="button" class="icon-btn" popovertarget="view-req-{{ $req->id }}" title="View full lab request details" style="background:#f1f5f9;color:#334155;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Action: Delete Request -->
                                        <button type="button" class="icon-btn red" popovertarget="delete-req-{{ $req->id }}" title="Cancel / Delete lab request">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:36px;color:#64748b;">
                                    <i class="fa-solid fa-flask" style="font-size:32px;color:#cbd5e1;display:block;margin-bottom:10px;"></i>
                                    No patient lab test requests recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination" style="margin-top:16px;">
                    <span style="color:#64748b;font-size:13px;font-weight:600;">
                        Showing {{ $lab_requests->count() }} lab request(s)
                    </span>
                </div>
            </div>
        </div>

        <!-- =====================================================
             REQUEST MODALS (PLACED OUTSIDE TABLE)
        ====================================================== -->
        @foreach($lab_requests as $req)
            @php
                $patientName = $req->user->name ?? ($req->patient->user->name ?? 'Walk-in Patient');
                $patientEmail = $req->user->email ?? ($req->patient->user->email ?? 'N/A');
            @endphp

            <!-- 1. Upload Result Modal (Word / Image / PDF) -->
            <div id="upload-result-{{ $req->id }}" popover class="modal-box">
                <div class="modal-content" style="max-width:620px;">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <i class="fa-solid fa-file-medical"></i> Upload Lab Result — {{ $req->request_number ?? ('#' . $req->id) }}
                        </h3>
                        <button type="button" popovertarget="upload-result-{{ $req->id }}" popovertargetaction="hide" class="modal-close-x">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.lab_requests.uploadResult', $req->id) }}" enctype="multipart/form-data" class="doctor-form">
                        @csrf

                        <div class="modal-body" style="padding:20px;">
                            <div style="background:#f8fafc;padding:12px 16px;border-radius:8px;border:1px solid #e2e8f0;margin-bottom:18px;font-size:13px;">
                                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                    <span style="color:#64748b;">Patient:</span>
                                    <strong style="color:#0f172a;">{{ $patientName }}</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between;">
                                    <span style="color:#64748b;">Tests Requested:</span>
                                    <span style="font-weight:600;color:#2563eb;">{{ $req->items->pluck('test_name')->join(', ') }}</span>
                                </div>
                            </div>

                            <div class="form-grid">
                                <!-- Document File Input -->
                                <div class="field full">
                                    <label>Upload Official Test Result Document *</label>
                                    <input type="file" name="result_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" required style="border:2px dashed #93c5fd;padding:12px;width:100%;border-radius:8px;background:#f0f9ff;">
                                    <small style="color:#64748b;margin-top:5px;display:block;">
                                        Supported formats: <strong>Word (.doc, .docx)</strong>, <strong>PDF (.pdf)</strong>, or <strong>Images (.jpg, .png, .webp)</strong>. Max file size: 10MB.
                                    </small>

                                    @if($req->result_document)
                                        <div style="margin-top:8px;padding:8px 12px;background:#ecfdf5;border-radius:6px;font-size:12.5px;color:#065f46;display:flex;align-items:center;justify-content:space-between;">
                                            <span><i class="fa-solid fa-circle-check"></i> Current file: {{ $req->result_file_name }}</span>
                                            <a href="{{ route('admin.lab_requests.downloadResult', $req->id) }}" style="color:#2563eb;font-weight:700;text-decoration:none;">Download</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Technician Diagnostic Notes -->
                                <div class="field full">
                                    <label>Technician Findings & Clinical Observations</label>
                                    <textarea name="result_notes" rows="4" placeholder="Enter diagnostic observations, abnormal values, or technician remarks...">{{ $req->result_notes }}</textarea>
                                </div>
                            </div>

                            <div style="margin-top:14px;background:#f0fdf4;padding:12px;border-radius:8px;border:1px solid #bbf7d0;font-size:12.5px;color:#166534;display:flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-circle-info" style="font-size:16px;"></i>
                                <span>Uploading this document will automatically mark the request status as <strong>Delivered / Completed</strong> and make the document accessible to the patient.</span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" popovertarget="upload-result-{{ $req->id }}" popovertargetaction="hide" class="close-btn">Cancel</button>
                            <button type="submit" class="save-btn" style="background:#2563eb;">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Upload & Complete Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. View Request Details Modal -->
            <div id="view-req-{{ $req->id }}" popover class="modal-box">
                <div class="modal-content" style="max-width:640px;">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <i class="fa-solid fa-clipboard-check"></i> Lab Request Summary — {{ $req->request_number ?? ('#' . $req->id) }}
                        </h3>
                        <button type="button" popovertarget="view-req-{{ $req->id }}" popovertargetaction="hide" class="modal-close-x">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body" style="padding:20px;">
                        <!-- Request Metadata Grid -->
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;background:#f8fafc;padding:14px;border-radius:10px;border:1px solid #e2e8f0;margin-bottom:18px;">
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Patient Name</span>
                                <strong style="display:block;font-size:14px;color:#0f172a;">{{ $patientName }}</strong>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Contact Email</span>
                                <strong style="display:block;font-size:14px;color:#0f172a;">{{ $patientEmail }}</strong>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Scheduled Date</span>
                                <span style="display:block;font-size:13px;color:#334155;">{{ $req->scheduled_date ? \Carbon\Carbon::parse($req->scheduled_date)->format('M d, Y') : 'N/A' }} at {{ $req->scheduled_time ?? '09:00 AM' }}</span>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Fulfillment Status</span>
                                <span style="display:block;font-size:13px;font-weight:700;color:{{ in_array($req->status, ['delivered', 'completed']) ? '#059669' : '#d97706' }};">
                                    {{ strtoupper($req->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Address & Notes -->
                        @if($req->address || $req->notes)
                            <div style="margin-bottom:16px;background:#f1f5f9;padding:12px;border-radius:8px;font-size:12.5px;color:#334155;">
                                @if($req->address)
                                    <div><strong>Sample Collection Location:</strong> {{ $req->address }}</div>
                                @endif
                                @if($req->notes)
                                    <div style="margin-top:4px;"><strong>Patient Notes:</strong> {{ $req->notes }}</div>
                                @endif
                            </div>
                        @endif

                        <!-- Requested Tests Table -->
                        <h4 style="font-size:14px;font-weight:700;margin-bottom:10px;color:#1e293b;">Tests Included</h4>
                        <table style="width:100%;border-collapse:collapse;margin-bottom:16px;font-size:13px;">
                            <thead>
                                <tr style="background:#f1f5f9;text-align:left;color:#475569;font-weight:700;">
                                    <th style="padding:8px 10px;border-radius:6px 0 0 6px;">Test Name</th>
                                    <th style="padding:8px 10px;">Category</th>
                                    <th style="padding:8px 10px;text-align:right;border-radius:0 6px 6px 0;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($req->items as $item)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:10px;font-weight:600;color:#1e293b;">
                                            {{ $item->test_name ?? ($item->test->name ?? 'Lab Test') }}
                                        </td>
                                        <td style="padding:10px;color:#475569;">
                                            {{ $item->test->category ?? 'General' }}
                                        </td>
                                        <td style="padding:10px;text-align:right;font-weight:700;color:#0f172a;">
                                            {{ number_format($item->price, 0, '.', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Total Bill -->
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#ecfdf5;border-radius:8px;border:1px solid #a7f3d0;margin-bottom:16px;">
                            <span style="font-weight:700;color:#065f46;font-size:14px;">Total Amount:</span>
                            <strong style="color:#059669;font-size:18px;">{{ number_format($req->total_amount, 0, '.', ' ') }} FCFA</strong>
                        </div>

                        <!-- Result Section in Details -->
                        @if($req->result_document)
                            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:14px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                    <strong style="color:#166534;font-size:13.5px;"><i class="fa-solid fa-file-circle-check"></i> Diagnostic Result Attached</strong>
                                    <a href="{{ route('admin.lab_requests.downloadResult', $req->id) }}" class="save-btn" style="padding:5px 12px;font-size:12px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-download"></i> Download {{ strtoupper($req->result_file_type ?? 'File') }}
                                    </a>
                                </div>
                                @if($req->result_notes)
                                    <p style="margin:0;font-size:12.5px;color:#334155;"><strong>Findings:</strong> {{ $req->result_notes }}</p>
                                @endif
                                <div style="font-size:11px;color:#64748b;margin-top:6px;">Uploaded on {{ $req->result_uploaded_at ? $req->result_uploaded_at->format('M d, Y - h:i A') : 'N/A' }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        @if(!in_array($req->status, ['delivered', 'completed']))
                            <form method="POST" action="{{ route('admin.lab_requests.updateStatus', $req->id) }}" style="display:inline;margin:0;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="save-btn" style="background:#10b981;">
                                    <i class="fa-solid fa-check"></i> Mark as Delivered
                                </button>
                            </form>
                        @endif
                        <button type="button" popovertarget="view-req-{{ $req->id }}" popovertargetaction="hide" class="close-btn">Close</button>
                    </div>
                </div>
            </div>

            <!-- 3. Delete Request Modal -->
            <div id="delete-req-{{ $req->id }}" popover class="alert-modal-box">
                <div class="alert-modal-content">
                    <div class="alert-modal-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="alert-modal-title">Delete Lab Request</h3>
                    <p class="alert-modal-desc">
                        Are you sure you want to remove lab request <strong>{{ $req->request_number ?? ('#' . $req->id) }}</strong> placed by <strong>{{ $patientName }}</strong>?
                    </p>
                    <div class="alert-modal-box-warning">
                        <strong>Irreversible Action:</strong> All attached sample records and uploaded result files will be permanently erased.
                    </div>
                    <div class="alert-modal-actions">
                        <button type="button" popovertarget="delete-req-{{ $req->id }}" popovertargetaction="hide" class="btn-modal-cancel">Cancel</button>
                        <form method="POST" action="{{ route('admin.lab_requests.delete', $req->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modal-danger">
                                <i class="fa-solid fa-trash"></i> Yes, Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

    <!-- =====================================================
         CREATE NEW LAB TEST MODAL (POPOVER)
    ====================================================== -->
    <div id="create-labtest-modal" popover class="modal-box">
        <div class="modal-content" style="max-width:640px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fa-solid fa-flask"></i> Add New Laboratory Test
                </h3>
                <button type="button" popovertarget="create-labtest-modal" popovertargetaction="hide" class="modal-close-x">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.lab_tests.store') }}" enctype="multipart/form-data" class="doctor-form">
                @csrf

                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom:16px;">
                            <strong>Please correct the following errors:</strong>
                            <ul style="margin-top:6px;padding-left:20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-grid">
                        <!-- Image -->
                        <div class="field full">
                            <label for="test_image">Lab Test Image</label>
                            <input type="file" id="test_image" name="image" accept="image/*" style="border:1px dashed #cbd5e1;padding:8px;width:100%;border-radius:6px;">
                        </div>

                        <!-- Name -->
                        <div class="field full">
                            <label for="test_name">Test Name *</label>
                            <input type="text" id="test_name" name="name" value="{{ old('name') }}" placeholder="e.g. Full Blood Count (FBC)" required>
                        </div>

                        <!-- Category -->
                        <div class="field">
                            <label for="test_category">Category *</label>
                            <input type="text" id="test_category" name="category" value="{{ old('category') }}" placeholder="e.g. Hematology, Biochemistry, Immunology" required>
                        </div>

                        <!-- Price -->
                        <div class="field">
                            <label for="test_price">Price (FCFA) *</label>
                            <input type="number" id="test_price" name="price" value="{{ old('price') }}" min="0" step="1" placeholder="e.g. 3500" required>
                        </div>

                        <!-- Preparation -->
                        <div class="field full">
                            <label for="test_prep">Patient Preparation & Sample Instructions</label>
                            <input type="text" id="test_prep" name="preparation" value="{{ old('preparation') }}" placeholder="e.g. 10 hours overnight fasting required">
                        </div>

                        <!-- Description -->
                        <div class="field full">
                            <label for="test_desc">Description & Diagnostic Scope</label>
                            <textarea id="test_desc" name="description" rows="3" placeholder="Describe the purpose, normal ranges, and clinical indications for this test...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="required-note" style="margin-top:12px;font-size:12px;color:#64748b;">
                        <i class="fa-solid fa-circle-info"></i> All fields marked with * are required.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" popovertarget="create-labtest-modal" popovertargetaction="hide" class="close-btn">Cancel</button>
                    <button type="submit" class="save-btn"><i class="fa-solid fa-plus"></i> Save Lab Test</button>
                </div>
            </form>
        </div>
    </div>

    <!-- =====================================================
         ACTION GUIDE (MATCHING SYSTEM STANDARDS)
    ====================================================== -->
    <div class="action-guide" style="margin-top:30px;">
        <div class="guide-title">Laboratory Management Guide</div>
        <div class="guide-grid">
            <div class="guide-item">
                <div class="guide-icon blue"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                <div>
                    <strong>Upload Test Result</strong>
                    <span>Attach official Word, PDF, or Image diagnostic result documents for patients.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon green"><i class="fa-solid fa-check"></i></div>
                <div>
                    <strong>Mark Delivered</strong>
                    <span>Confirm completed analysis and timestamp patient test delivery.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon" style="background:#fffbeb;color:#d97706;"><i class="fa-solid fa-rotate-left"></i></div>
                <div>
                    <strong>Pending Revert</strong>
                    <span>Re-queue test status back to pending sample collection or review.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon orange"><i class="fa-solid fa-pen"></i></div>
                <div>
                    <strong>Edit Lab Test</strong>
                    <span>Update pricing, preparation guidelines, categories, and test details.</span>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
