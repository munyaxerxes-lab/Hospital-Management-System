@extends('layout.index')
@section('content')

<div class="labtest-page">

    <!-- =====================================================
         PAGE HERO HEADER
    ====================================================== -->
    <div class="labtest-hero">
        <div class="hero-left">
            <div class="hero-tag">
                <i class="fa-solid fa-flask-vial"></i>
                Hospital Laboratory Services
            </div>
            <h1 class="hero-title">Quick Lab Test Request</h1>
            <p class="hero-subtitle">
                Select the tests you need — our medical team will come to you to collect samples. Results will be securely uploaded and accessible from your history.
            </p>

            <!-- Flow Steps Badge Row -->
            <div class="flow-steps-row">
                <div class="flow-step">
                    <div class="flow-step-icon"><i class="fa-solid fa-check-square"></i></div>
                    <div class="flow-step-text"><strong>1. Select Tests</strong><span>Choose what you need</span></div>
                </div>
                <div class="flow-connector"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="flow-step">
                    <div class="flow-step-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="flow-step-text"><strong>2. Book Slot</strong><span>Pick preferred date/time</span></div>
                </div>
                <div class="flow-connector"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="flow-step">
                    <div class="flow-step-icon"><i class="fa-solid fa-user-nurse"></i></div>
                    <div class="flow-step-text"><strong>3. Sample Collected</strong><span>Team visits your location</span></div>
                </div>
                <div class="flow-connector"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="flow-step">
                    <div class="flow-step-icon"><i class="fa-solid fa-file-medical"></i></div>
                    <div class="flow-step-text"><strong>4. View Results</strong><span>Available in your History</span></div>
                </div>
            </div>
        </div>

        <!-- Hero Stats -->
        <div class="hero-stats-box">
            <div class="hero-stat">
                <span class="stat-number">{{ $lab_tests->count() }}</span>
                <span class="stat-label">Tests Available</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="stat-number">24h</span>
                <span class="stat-label">Avg. Turnaround</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <span class="stat-number">100%</span>
                <span class="stat-label">Lab Certified</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="flash-alert flash-success" id="flashMsg">
            <i class="fa-solid fa-circle-check"></i>
            <div><strong>Request Submitted!</strong><p>{{ session('success') }}</p></div>
            <button type="button" onclick="this.closest('.flash-alert').remove()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="flash-alert flash-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div><strong>Error</strong><p>{{ session('error') }}</p></div>
            <button type="button" onclick="this.closest('.flash-alert').remove()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- =====================================================
         MULTI-STEP BOOKING FORM
    ====================================================== -->
    <form id="labBookingForm" action="{{ route('patient.lab_request.store') }}" method="POST">
        @csrf

        <!-- Step Progress Tracker -->
        <div class="step-tracker-bar">
            <div class="step-track-item active" id="track-step-1">
                <div class="track-circle">1</div>
                <span>Choose Tests</span>
            </div>
            <div class="track-line" id="line-1"></div>
            <div class="step-track-item" id="track-step-2">
                <div class="track-circle">2</div>
                <span>Schedule &amp; Details</span>
            </div>
            <div class="track-line" id="line-2"></div>
            <div class="step-track-item" id="track-step-3">
                <div class="track-circle">3</div>
                <span>Confirm &amp; Submit</span>
            </div>
        </div>

        <!-- ==============================================
             STEP 1 — SELECT TESTS
        =============================================== -->
        <div class="booking-step" id="step-1">

            <div class="tests-toolbar">
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="testSearch" placeholder="Search tests by name or category…" autocomplete="off">
                </div>
                <div class="filter-pills" id="categoryFilter">
                    <button type="button" class="fpill active" data-cat="all">All Tests</button>
                    @foreach($lab_tests->pluck('category')->unique()->filter()->values() as $cat)
                        <button type="button" class="fpill" data-cat="{{ strtolower($cat) }}">{{ $cat }}</button>
                    @endforeach
                </div>
            </div>

            <div class="tests-grid" id="testsGrid">
                @forelse($lab_tests->where('status', true) as $test)
                    @php $fallback = asset('image/lab1.png'); @endphp
                    <div class="test-card"
                         data-id="{{ $test->id }}"
                         data-name="{{ strtolower($test->name) }}"
                         data-cat="{{ strtolower($test->category ?? 'general') }}"
                         data-price="{{ $test->price }}"
                         tabindex="0" role="checkbox" aria-checked="false">

                        <div class="card-check-ring" id="check-{{ $test->id }}">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <input type="checkbox" name="test_ids[]" value="{{ $test->id }}" class="test-checkbox-input" id="chk-{{ $test->id }}">

                        <div class="test-card-image">
                            <img src="{{ $test->image_url ?? $fallback }}" alt="{{ $test->name }}" loading="lazy" onerror="this.onerror=null; this.src='{{ $fallback }}';">
                        </div>

                        <div class="test-card-body">
                            <div class="test-category-tag"><i class="fa-solid fa-tag"></i> {{ $test->category ?? 'General' }}</div>
                            <h3 class="test-card-title">{{ $test->name }}</h3>
                            <p class="test-card-desc">{{ \Illuminate\Support\Str::limit($test->description ?? 'Standard diagnostic test', 80) }}</p>
                            @if($test->preparation)
                                <div class="test-prep-note">
                                    <i class="fa-solid fa-circle-info"></i>
                                    {{ \Illuminate\Support\Str::limit($test->preparation, 60) }}
                                </div>
                            @endif
                        </div>

                        <div class="test-card-footer">
                            <strong class="test-price">{{ number_format($test->price, 0, '.', ' ') }} <small>FCFA</small></strong>
                            <span class="add-test-label"><i class="fa-solid fa-plus-circle"></i> Add</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-tests-box">
                        <i class="fa-solid fa-flask"></i>
                        <h3>No lab tests available right now</h3>
                        <p>Please check back soon or contact the lab department.</p>
                    </div>
                @endforelse
            </div>

            <div id="noTestResults" class="empty-tests-box" style="display:none;">
                <i class="fa-solid fa-magnifying-glass"></i>
                <h3>No matching tests found</h3>
                <p>Try a different keyword or category.</p>
            </div>

            <!-- Sticky Selection Summary Bar -->
            <div class="selection-sticky-bar" id="stickySelectionBar" style="display:none;">
                <div class="selection-info">
                    <span class="selected-count-badge" id="selectedCount">0</span>
                    <span class="selected-label">test(s) selected</span>
                    <div class="selected-tags" id="selectedTags"></div>
                </div>
                <div class="selection-total">
                    <span class="total-label">Estimated Total</span>
                    <strong class="total-amount" id="selectionTotal">0 FCFA</strong>
                </div>
                <button type="button" class="btn-next-step" onclick="goToStep(2)">
                    Continue to Schedule <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- ==============================================
             STEP 2 — SCHEDULE & DETAILS
        =============================================== -->
        <div class="booking-step" id="step-2" style="display:none;">
            <div class="step2-layout">
                <div class="step2-main">
                    <h2 class="step-section-title"><i class="fa-solid fa-calendar-days"></i> Preferred Collection Details</h2>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="scheduled_date">
                                <i class="fa-solid fa-calendar"></i> Preferred Date <span class="req">*</span>
                            </label>
                            <input type="date" id="scheduled_date" name="scheduled_date" class="form-control"
                                   min="{{ now()->addDay()->toDateString() }}" value="{{ now()->addDay()->toDateString() }}" required>
                            <p class="form-hint">Collection can only be scheduled from tomorrow onwards.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="scheduled_time">
                                <i class="fa-solid fa-clock"></i> Preferred Time Slot <span class="req">*</span>
                            </label>
                            <select id="scheduled_time" name="scheduled_time" class="form-control" required>
                                <option value="">Select a time slot…</option>
                                <option value="07:00 AM">07:00 AM – Early Morning</option>
                                <option value="08:00 AM">08:00 AM – Morning</option>
                                <option value="09:00 AM" selected>09:00 AM – Morning (Recommended)</option>
                                <option value="10:00 AM">10:00 AM – Late Morning</option>
                                <option value="11:00 AM">11:00 AM – Late Morning</option>
                                <option value="12:00 PM">12:00 PM – Midday</option>
                                <option value="02:00 PM">02:00 PM – Afternoon</option>
                                <option value="03:00 PM">03:00 PM – Afternoon</option>
                                <option value="04:00 PM">04:00 PM – Late Afternoon</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label" for="address">
                                <i class="fa-solid fa-location-dot"></i> Sample Collection Location <span class="req">*</span>
                            </label>
                            <input type="text" id="address" name="address" class="form-control"
                                   placeholder="e.g. Ward 4, Room 12 – or your home address"
                                   value="{{ auth()->user()->address ?? '' }}" required>
                            <p class="form-hint">The medical team will come to this location to collect the sample.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="payment_method">
                                <i class="fa-solid fa-credit-card"></i> Payment Method
                            </label>
                            <select id="payment_method" name="payment_method" class="form-control">
                                <option value="cash_on_delivery">Cash – Pay on Collection</option>
                                <option value="mobile_money">Mobile Money (MTN / Orange)</option>
                                <option value="hospital_billing">Hospital Billing / Insurance</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label" for="notes">
                                <i class="fa-solid fa-note-sticky"></i> Additional Notes <span class="opt">(Optional)</span>
                            </label>
                            <textarea id="notes" name="notes" class="form-control" rows="3"
                                      placeholder="Symptoms, allergies, special instructions for the lab technician…" maxlength="1000"></textarea>
                            <p class="form-hint char-counter"><span id="notesCharCount">0</span> / 1000 characters</p>
                        </div>
                    </div>

                    <div class="step-nav-btns">
                        <button type="button" class="btn-prev-step" onclick="goToStep(1)">
                            <i class="fa-solid fa-arrow-left"></i> Back to Tests
                        </button>
                        <button type="button" class="btn-next-step" onclick="goToStep(3)">
                            Review Order <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Info sidebar -->
                <div class="step2-sidebar">
                    <div class="info-card">
                        <h4><i class="fa-solid fa-circle-info"></i> What happens next?</h4>
                        <ul class="info-steps-list">
                            <li>
                                <div class="info-step-num">1</div>
                                <div><strong>Confirmation</strong><p>Your request is registered immediately with a unique reference number.</p></div>
                            </li>
                            <li>
                                <div class="info-step-num">2</div>
                                <div><strong>Sample Collection</strong><p>A certified lab technician visits your location on the selected date & time.</p></div>
                            </li>
                            <li>
                                <div class="info-step-num">3</div>
                                <div><strong>Lab Processing</strong><p>Samples are analyzed at our in-hospital accredited laboratory.</p></div>
                            </li>
                            <li>
                                <div class="info-step-num">4</div>
                                <div><strong>Results Ready</strong><p>Results are securely uploaded and visible in your <strong>History</strong> section.</p></div>
                            </li>
                        </ul>
                    </div>
                    <div class="info-card info-card-tip">
                        <i class="fa-solid fa-lightbulb"></i>
                        <div>
                            <strong>Fasting Required?</strong>
                            <p>Some tests (like Blood Sugar) require 8–12 hours of fasting. You'll receive specific instructions after booking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================================
             STEP 3 — REVIEW & CONFIRM
        =============================================== -->
        <div class="booking-step" id="step-3" style="display:none;">
            <h2 class="step-section-title"><i class="fa-solid fa-clipboard-check"></i> Review &amp; Confirm Your Request</h2>

            <div class="review-layout">
                <div class="review-main">

                    <!-- Selected Tests -->
                    <div class="review-card">
                        <div class="review-card-header">
                            <i class="fa-solid fa-flask-vial"></i>
                            <span>Selected Tests</span>
                            <button type="button" class="edit-link" onclick="goToStep(1)"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        </div>
                        <div id="reviewTestsList" class="review-tests-list"></div>
                        <div class="review-subtotal-row">
                            <span>Tests Subtotal</span>
                            <strong id="reviewSubtotal">0 FCFA</strong>
                        </div>
                    </div>

                    <!-- Schedule Details -->
                    <div class="review-card">
                        <div class="review-card-header">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Collection Schedule</span>
                            <button type="button" class="edit-link" onclick="goToStep(2)"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        </div>
                        <div class="review-detail-grid">
                            <div class="review-detail-item">
                                <i class="fa-solid fa-calendar"></i>
                                <div><span class="rdi-label">Preferred Date</span><strong id="reviewDate">—</strong></div>
                            </div>
                            <div class="review-detail-item">
                                <i class="fa-solid fa-clock"></i>
                                <div><span class="rdi-label">Time Slot</span><strong id="reviewTime">—</strong></div>
                            </div>
                            <div class="review-detail-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <div><span class="rdi-label">Collection Location</span><strong id="reviewAddress">—</strong></div>
                            </div>
                            <div class="review-detail-item">
                                <i class="fa-solid fa-credit-card"></i>
                                <div><span class="rdi-label">Payment</span><strong id="reviewPayment">—</strong></div>
                            </div>
                        </div>
                        <div id="reviewNotesBox" class="review-notes-box" style="display:none;">
                            <i class="fa-solid fa-note-sticky"></i><p id="reviewNotes"></p>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary Sidebar -->
                <div class="review-sidebar">
                    <div class="payment-summary-card">
                        <h3><i class="fa-solid fa-receipt"></i> Payment Summary</h3>
                        <div class="ps-rows">
                            <div class="ps-row">
                                <span>Lab Tests (<span id="psTestCount">0</span>)</span>
                                <span id="psSubtotal">0 FCFA</span>
                            </div>
                            <div class="ps-row">
                                <span>Sample Collection Fee</span>
                                <span class="free-chip">FREE</span>
                            </div>
                            <div class="ps-row">
                                <span>Processing Fee</span>
                                <span class="free-chip">INCLUDED</span>
                            </div>
                        </div>
                        <div class="ps-total-row">
                            <span>Total Due</span>
                            <strong id="psTotal">0 FCFA</strong>
                        </div>
                        <div class="ps-trust">
                            <div class="ps-trust-item"><i class="fa-solid fa-shield-halved"></i><span>Secure Booking</span></div>
                            <div class="ps-trust-item"><i class="fa-solid fa-user-nurse"></i><span>Certified Techs</span></div>
                            <div class="ps-trust-item"><i class="fa-solid fa-lock"></i><span>Private Results</span></div>
                        </div>
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="fa-solid fa-paper-plane"></i> Confirm &amp; Submit Request
                        </button>
                        <p class="submit-note">After submission you will receive a reference number. Track your request in <strong>History</strong>.</p>
                    </div>
                    <button type="button" class="btn-prev-step full" onclick="goToStep(2)">
                        <i class="fa-solid fa-arrow-left"></i> Back to Schedule
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<div id="labToastContainer" class="lab-toast-container" aria-live="polite"></div>

<style>
.labtest-page { max-width:1280px; margin:0 auto; padding:20px 20px 60px; font-family:inherit; }

/* Hero */
.labtest-hero { background:linear-gradient(135deg,#1a56db 0%,#0f3d8c 100%); border-radius:20px; padding:32px 36px; color:#fff; display:flex; justify-content:space-between; align-items:flex-start; gap:24px; margin-bottom:28px; position:relative; overflow:hidden; box-shadow:0 10px 40px rgba(26,86,219,.22); }
.labtest-hero::after { content:''; position:absolute; right:-60px; bottom:-60px; width:260px; height:260px; border-radius:50%; background:radial-gradient(circle,rgba(255,255,255,.08) 0%,transparent 70%); pointer-events:none; }
.hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,.15); backdrop-filter:blur(6px); padding:6px 14px; border-radius:99px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin-bottom:12px; }
.hero-title { font-size:30px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.2; }
.hero-subtitle { font-size:14px; color:#bfdbfe; margin:0 0 20px; max-width:600px; line-height:1.6; }
.flow-steps-row { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:4px; }
.flow-step { display:flex; align-items:center; gap:10px; background:rgba(255,255,255,.12); padding:8px 14px; border-radius:10px; backdrop-filter:blur(4px); }
.flow-step-icon { font-size:18px; color:#93c5fd; }
.flow-step-text strong { display:block; font-size:12px; color:#fff; }
.flow-step-text span { font-size:11px; color:#93c5fd; }
.flow-connector { color:rgba(255,255,255,.3); font-size:12px; }
.hero-stats-box { display:flex; flex-direction:column; align-items:center; gap:12px; background:rgba(255,255,255,.12); border-radius:14px; padding:24px 28px; text-align:center; flex-shrink:0; backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.15); }
.hero-stat { display:flex; flex-direction:column; align-items:center; }
.stat-number { font-size:28px; font-weight:900; color:#fff; line-height:1; }
.stat-label { font-size:11px; color:#93c5fd; font-weight:600; text-transform:uppercase; margin-top:3px; }
.hero-stat-divider { width:100%; height:1px; background:rgba(255,255,255,.15); }

/* Flash */
.flash-alert { display:flex; align-items:flex-start; gap:14px; padding:16px 18px; border-radius:12px; margin-bottom:20px; position:relative; }
.flash-success { background:#f0fdf4; border:1.5px solid #bbf7d0; color:#065f46; }
.flash-error   { background:#fef2f2; border:1.5px solid #fecaca; color:#991b1b; }
.flash-alert > i:first-child { font-size:20px; flex-shrink:0; margin-top:2px; }
.flash-alert button { position:absolute; top:12px; right:14px; background:none; border:none; cursor:pointer; color:#94a3b8; font-size:14px; }
.flash-alert strong { font-size:14px; display:block; }
.flash-alert p { font-size:13px; margin:2px 0 0; }

/* Step Tracker */
.step-tracker-bar { display:flex; align-items:center; justify-content:center; gap:0; margin:0 auto 28px; max-width:600px; }
.step-track-item { display:flex; flex-direction:column; align-items:center; gap:6px; font-size:12.5px; color:#94a3b8; font-weight:600; min-width:100px; text-align:center; transition:color .2s; }
.track-circle { width:38px; height:38px; border-radius:50%; background:#f1f5f9; border:2px solid #e2e8f0; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#94a3b8; transition:all .25s; }
.step-track-item.active .track-circle { background:#1a56db; border-color:#1a56db; color:#fff; box-shadow:0 4px 14px rgba(26,86,219,.35); }
.step-track-item.done   .track-circle { background:#10b981; border-color:#10b981; color:#fff; }
.step-track-item.active { color:#1a56db; }
.step-track-item.done   { color:#10b981; }
.track-line { flex:1; height:2px; background:#e2e8f0; margin-bottom:24px; transition:background .3s; }
.track-line.done { background:#10b981; }

/* Search / Filter */
.tests-toolbar { display:flex; align-items:center; flex-wrap:wrap; gap:14px; margin-bottom:20px; }
.search-wrap { position:relative; flex:1; min-width:260px; max-width:440px; }
.search-wrap input { width:100%; padding:11px 14px 11px 40px; border:1.5px solid #cbd5e1; border-radius:10px; font-size:14px; background:#fff; outline:none; transition:border-color .2s; }
.search-wrap input:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.1); }
.search-wrap > i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px; }
.filter-pills { display:flex; gap:8px; flex-wrap:wrap; }
.fpill { padding:7px 16px; border-radius:99px; border:1.5px solid #e2e8f0; background:#fff; color:#475569; font-size:12.5px; font-weight:600; cursor:pointer; transition:all .18s; }
.fpill:hover { border-color:#1a56db; color:#1a56db; }
.fpill.active { background:#1a56db; border-color:#1a56db; color:#fff; box-shadow:0 3px 10px rgba(26,86,219,.25); }

/* Tests Grid */
.tests-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:18px; margin-bottom:20px; }

/* Test Card */
.test-card { background:#fff; border:2px solid #e2e8f0; border-radius:16px; cursor:pointer; position:relative; overflow:hidden; transition:all .22s cubic-bezier(.4,0,.2,1); display:flex; flex-direction:column; outline:none; }
.test-card:hover { border-color:#93c5fd; box-shadow:0 8px 24px rgba(26,86,219,.1); transform:translateY(-3px); }
.test-card.selected { border-color:#1a56db; background:#f0f7ff; box-shadow:0 6px 20px rgba(26,86,219,.15); }
.card-check-ring { position:absolute; top:12px; right:12px; width:28px; height:28px; border-radius:50%; border:2px solid #cbd5e1; background:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; color:transparent; transition:all .2s; z-index:2; }
.test-card.selected .card-check-ring { background:#1a56db; border-color:#1a56db; color:#fff; }
.test-checkbox-input { display:none; }
.test-card-image { width:100%; height:140px; background:#f0f7ff; overflow:hidden; display:flex; align-items:center; justify-content:center; }
.test-card-image img { width:100%; height:100%; object-fit:cover; transition:transform .3s ease; }
.test-card:hover .test-card-image img { transform:scale(1.06); }
.test-card-body { padding:14px 16px 10px; flex:1; }
.test-category-tag { font-size:10.5px; font-weight:700; color:#1a56db; background:#eff6ff; padding:3px 8px; border-radius:5px; display:inline-flex; align-items:center; gap:4px; margin-bottom:8px; }
.test-card-title { font-size:15px; font-weight:700; color:#0f172a; margin:0 0 5px; line-height:1.3; }
.test-card-desc { font-size:12.5px; color:#64748b; margin:0 0 8px; line-height:1.45; }
.test-prep-note { font-size:11.5px; color:#0369a1; background:#f0f9ff; border-left:3px solid #38bdf8; padding:6px 10px; border-radius:0 6px 6px 0; display:flex; align-items:flex-start; gap:6px; margin-top:6px; }
.test-card-footer { padding:10px 16px 14px; display:flex; align-items:center; justify-content:space-between; border-top:1.5px solid #f1f5f9; background:#fafcff; }
.test-price { font-size:16px; font-weight:800; color:#059669; }
.test-price small { font-size:11px; color:#64748b; font-weight:600; }
.add-test-label { font-size:12px; font-weight:700; color:#1a56db; display:flex; align-items:center; gap:5px; }
.test-card.selected .add-test-label { color:#10b981; }

/* Empty state */
.empty-tests-box { grid-column:1/-1; text-align:center; padding:50px 24px; background:#fff; border:2px dashed #cbd5e1; border-radius:16px; color:#64748b; }
.empty-tests-box > i { font-size:36px; color:#cbd5e1; margin-bottom:12px; display:block; }
.empty-tests-box h3 { font-size:17px; font-weight:700; color:#334155; margin:0 0 6px; }

/* Sticky Bar */
.selection-sticky-bar { position:sticky; bottom:16px; background:#0f172a; color:#fff; border-radius:14px; padding:16px 22px; display:flex; align-items:center; gap:20px; box-shadow:0 12px 36px rgba(0,0,0,.28); z-index:50; margin-top:16px; animation:slideUp .3s ease; }
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.selected-count-badge { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:50%; background:#1a56db; color:#fff; font-size:14px; font-weight:800; flex-shrink:0; }
.selected-label { font-size:14px; font-weight:600; color:#94a3b8; }
.selected-tags { display:flex; gap:6px; flex-wrap:wrap; }
.selection-tag { background:rgba(255,255,255,.1); font-size:11.5px; font-weight:600; color:#e2e8f0; padding:3px 10px; border-radius:6px; }
.selection-info { display:flex; align-items:center; gap:10px; flex:1; flex-wrap:wrap; }
.selection-total { display:flex; flex-direction:column; margin-left:auto; text-align:right; }
.selection-total .total-label { font-size:11px; color:#64748b; font-weight:600; }
.selection-total .total-amount { font-size:20px; font-weight:900; color:#34d399; }

/* Nav Buttons */
.btn-next-step { background:#1a56db; color:#fff; border:none; padding:12px 24px; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:9px; box-shadow:0 4px 14px rgba(26,86,219,.3); transition:all .2s; flex-shrink:0; }
.btn-next-step:hover { background:#1d4ed8; transform:translateY(-1px); }
.btn-prev-step { background:#fff; color:#475569; border:1.5px solid #e2e8f0; padding:11px 22px; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:all .18s; }
.btn-prev-step:hover { border-color:#94a3b8; color:#0f172a; }
.btn-prev-step.full { width:100%; justify-content:center; }
.step-nav-btns { display:flex; justify-content:space-between; align-items:center; margin-top:24px; gap:14px; }

/* Step 2 */
.step2-layout { display:grid; grid-template-columns:1fr 320px; gap:24px; }
.step-section-title { display:flex; align-items:center; gap:10px; font-size:20px; font-weight:800; color:#0f172a; margin:0 0 20px; }
.step-section-title i { color:#1a56db; }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group.full-width { grid-column:1/-1; }
.form-label { font-size:13px; font-weight:700; color:#374151; display:flex; align-items:center; gap:7px; }
.form-label i { color:#6b7280; }
.form-label .req { color:#ef4444; }
.form-label .opt { color:#94a3b8; font-weight:500; }
.form-control { padding:11px 14px; border:1.5px solid #cbd5e1; border-radius:10px; font-size:14px; color:#0f172a; background:#fff; outline:none; font-family:inherit; transition:border-color .2s; }
.form-control:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.1); }
textarea.form-control { resize:vertical; min-height:80px; }
.form-hint { font-size:11.5px; color:#64748b; margin:0; }
.char-counter { display:flex; justify-content:flex-end; }
.info-card { background:#fff; border:1.5px solid #e2e8f0; border-radius:14px; padding:18px; margin-bottom:14px; }
.info-card h4 { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:800; color:#0f172a; margin:0 0 14px; }
.info-card h4 i { color:#1a56db; }
.info-steps-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:14px; }
.info-steps-list li { display:flex; gap:12px; align-items:flex-start; }
.info-step-num { width:24px; height:24px; border-radius:50%; background:#eff6ff; color:#1a56db; font-size:12px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
.info-steps-list li strong { font-size:13px; color:#0f172a; display:block; }
.info-steps-list li p { font-size:12px; color:#64748b; margin:3px 0 0; line-height:1.4; }
.info-card-tip { background:#fffbeb; border-color:#fde68a; display:flex; gap:12px; align-items:flex-start; }
.info-card-tip > i { font-size:20px; color:#d97706; margin-top:2px; flex-shrink:0; }
.info-card-tip strong { font-size:13px; color:#92400e; display:block; margin-bottom:4px; }
.info-card-tip p { font-size:12px; color:#78350f; margin:0; line-height:1.4; }

/* Step 3 Review */
.review-layout { display:grid; grid-template-columns:1fr 320px; gap:24px; }
.review-card { background:#fff; border:1.5px solid #e2e8f0; border-radius:14px; margin-bottom:16px; overflow:hidden; }
.review-card-header { display:flex; align-items:center; gap:10px; padding:14px 18px; background:#fafcff; border-bottom:1.5px solid #f1f5f9; font-weight:800; font-size:14.5px; color:#0f172a; }
.review-card-header i { color:#1a56db; }
.edit-link { margin-left:auto; background:none; border:1.5px solid #e2e8f0; padding:5px 12px; border-radius:7px; font-size:12px; font-weight:700; color:#1a56db; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all .15s; }
.edit-link:hover { background:#eff6ff; }
.review-tests-list { padding:14px 18px; display:flex; flex-direction:column; gap:10px; }
.review-test-item { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0; }
.rti-left { display:flex; align-items:center; gap:10px; }
.rti-left i { font-size:16px; color:#1a56db; }
.rti-name { font-size:13.5px; font-weight:700; color:#0f172a; }
.rti-cat  { font-size:11px; color:#64748b; }
.rti-price { font-size:14px; font-weight:800; color:#059669; }
.review-subtotal-row { display:flex; justify-content:space-between; align-items:center; padding:14px 18px; border-top:1.5px dashed #e2e8f0; font-size:14px; font-weight:700; color:#0f172a; }
.review-detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; padding:16px 18px; }
.review-detail-item { display:flex; align-items:flex-start; gap:10px; }
.review-detail-item > i { color:#1a56db; font-size:16px; margin-top:3px; flex-shrink:0; }
.rdi-label { font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; display:block; }
.review-detail-item strong { font-size:13.5px; color:#0f172a; font-weight:700; display:block; margin-top:2px; }
.review-notes-box { margin:0 18px 16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 14px; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#475569; }
.review-notes-box i { color:#94a3b8; flex-shrink:0; margin-top:1px; }

/* Payment Summary */
.payment-summary-card { background:#fff; border:1.5px solid #e2e8f0; border-radius:16px; overflow:hidden; margin-bottom:14px; }
.payment-summary-card h3 { display:flex; align-items:center; gap:10px; font-size:16px; font-weight:800; color:#0f172a; padding:18px 20px 14px; margin:0; border-bottom:1.5px solid #f1f5f9; background:#fafcff; }
.payment-summary-card h3 i { color:#1a56db; }
.ps-rows { padding:14px 20px; display:flex; flex-direction:column; gap:10px; border-bottom:1.5px dashed #e2e8f0; }
.ps-row { display:flex; justify-content:space-between; align-items:center; font-size:13.5px; color:#475569; }
.free-chip { font-size:11.5px; font-weight:800; color:#16a34a; background:#f0fdf4; padding:3px 10px; border-radius:6px; }
.ps-total-row { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; background:#f0f7ff; font-size:15px; font-weight:700; color:#0f172a; }
.ps-total-row strong { font-size:22px; font-weight:900; color:#059669; }
.ps-trust { display:flex; justify-content:space-around; padding:12px 16px; border-top:1.5px solid #f1f5f9; }
.ps-trust-item { display:flex; flex-direction:column; align-items:center; gap:5px; font-size:10.5px; font-weight:600; color:#64748b; text-align:center; }
.ps-trust-item i { font-size:18px; color:#1a56db; }
.submit-btn { width:100%; padding:16px 20px; background:linear-gradient(135deg,#1a56db 0%,#1d4ed8 100%); color:#fff; border:none; font-size:15px; font-weight:800; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; transition:all .22s; }
.submit-btn:hover { background:linear-gradient(135deg,#1e40af 0%,#1d3eb0 100%); box-shadow:0 6px 20px rgba(26,86,219,.3); }
.submit-btn:disabled { opacity:.65; cursor:not-allowed; }
.submit-note { font-size:11.5px; color:#64748b; padding:12px 18px; margin:0; text-align:center; line-height:1.5; border-top:1.5px solid #f1f5f9; }

/* Toast */
.lab-toast-container { position:fixed; bottom:24px; right:24px; display:flex; flex-direction:column; gap:10px; z-index:9999; pointer-events:none; }

/* Responsive */
@media (max-width:960px) {
    .labtest-hero { flex-direction:column; }
    .hero-stats-box { flex-direction:row; width:100%; justify-content:space-around; flex-wrap:wrap; }
    .hero-stat-divider { width:1px; height:40px; }
    .step2-layout, .review-layout { grid-template-columns:1fr; }
    .form-grid { grid-template-columns:1fr; }
    .form-group.full-width { grid-column:1; }
}
@media (max-width:680px) {
    .tests-grid { grid-template-columns:1fr 1fr; }
    .flow-steps-row { display:none; }
    .selection-sticky-bar { flex-direction:column; align-items:flex-start; gap:10px; }
    .btn-next-step { width:100%; justify-content:center; }
    .step-track-item { min-width:60px; font-size:10px; }
    .track-circle { width:30px; height:30px; font-size:12px; }
}
@media (max-width:480px) {
    .tests-grid { grid-template-columns:1fr; }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectedTests = new Map();
    let currentStep = 1;

    const cards      = document.querySelectorAll('.test-card');
    const stickyBar  = document.getElementById('stickySelectionBar');
    const countBadge = document.getElementById('selectedCount');
    const totalEl    = document.getElementById('selectionTotal');
    const tagsEl     = document.getElementById('selectedTags');
    const notesInput = document.getElementById('notes');
    const notesCount = document.getElementById('notesCharCount');

    function fcfa(n) {
        return new Intl.NumberFormat('fr-FR').format(n) + ' FCFA';
    }

    function toast(msg, type = 'info') {
        const c = { success:'#10b981', error:'#ef4444', info:'#1a56db' };
        const ico = { success:'fa-circle-check', error:'fa-triangle-exclamation', info:'fa-circle-info' };
        const el = document.createElement('div');
        el.style.cssText = `pointer-events:auto;background:#0f172a;color:#fff;padding:13px 18px;border-radius:12px;font-size:13.5px;display:flex;align-items:center;gap:12px;border-left:4px solid ${c[type]};box-shadow:0 10px 25px rgba(0,0,0,.25);min-width:260px;`;
        el.innerHTML = `<i class="fa-solid ${ico[type]}" style="color:${c[type]};font-size:17px;"></i><span>${msg}</span>`;
        document.getElementById('labToastContainer').appendChild(el);
        setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity .3s'; setTimeout(() => el.remove(), 300); }, 3800);
    }

    function updateStickyBar() {
        const count = selectedTests.size;
        const total = [...selectedTests.values()].reduce((s, t) => s + Number(t.price), 0);
        countBadge.textContent = count;
        totalEl.textContent    = fcfa(total);
        tagsEl.innerHTML       = '';
        [...selectedTests.values()].slice(0, 4).forEach(t => {
            const tag = document.createElement('span');
            tag.className = 'selection-tag';
            tag.textContent = t.name.length > 18 ? t.name.substring(0, 16) + '…' : t.name;
            tagsEl.appendChild(tag);
        });
        if (count > 4) {
            const m = document.createElement('span'); m.className='selection-tag'; m.textContent='+' + (count-4) + ' more'; tagsEl.appendChild(m);
        }
        stickyBar.style.display = count > 0 ? 'flex' : 'none';
    }

    cards.forEach(card => {
        const toggle = () => {
            const id       = card.dataset.id;
            const name     = card.querySelector('.test-card-title')?.textContent.trim() || '';
            const price    = parseFloat(card.dataset.price) || 0;
            const catTag   = card.querySelector('.test-category-tag')?.textContent.trim().replace(/^\S+\s/, '') || '';
            const checkbox = document.getElementById('chk-' + id);

            if (selectedTests.has(id)) {
                selectedTests.delete(id);
                card.classList.remove('selected');
                card.setAttribute('aria-checked', 'false');
                if (checkbox) checkbox.checked = false;
            } else {
                selectedTests.set(id, { name, price, category: catTag });
                card.classList.add('selected');
                card.setAttribute('aria-checked', 'true');
                if (checkbox) checkbox.checked = true;
            }
            updateStickyBar();
        };
        card.addEventListener('click', toggle);
        card.addEventListener('keydown', e => { if (e.key===' '||e.key==='Enter'){e.preventDefault();toggle();} });
    });

    // Search & filter
    document.getElementById('testSearch')?.addEventListener('input', filterTests);
    document.querySelectorAll('.fpill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.fpill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            filterTests();
        });
    });

    function filterTests() {
        const q    = document.getElementById('testSearch')?.value.toLowerCase().trim() || '';
        const cat  = document.querySelector('.fpill.active')?.dataset.cat || 'all';
        let visible = 0;
        cards.forEach(c => {
            const show = (c.dataset.name.includes(q)) && (cat==='all' || c.dataset.cat===cat);
            c.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        const no = document.getElementById('noTestResults');
        if (no) no.style.display = visible===0 ? 'block' : 'none';
    }

    notesInput?.addEventListener('input', () => { if (notesCount) notesCount.textContent = notesInput.value.length; });

    // Step navigation
    window.goToStep = function(step) {
        if (step === 2 && selectedTests.size === 0) {
            toast('Please select at least one lab test before continuing.', 'error'); return;
        }
        if (step === 3) {
            const date    = document.getElementById('scheduled_date')?.value;
            const time    = document.getElementById('scheduled_time')?.value;
            const address = document.getElementById('address')?.value.trim();
            if (!date)    { toast('Please select a preferred collection date.', 'error'); return; }
            if (!time)    { toast('Please select a preferred time slot.', 'error'); return; }
            if (!address) { toast('Please enter the collection location/address.', 'error'); return; }
            populateReview();
        }

        document.getElementById('step-' + currentStep).style.display = 'none';
        const nextEl = document.getElementById('step-' + step);
        nextEl.style.display = '';
        nextEl.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Update tracker
        const fromItem = document.getElementById('track-step-' + currentStep);
        if (fromItem && step > currentStep) {
            fromItem.classList.remove('active'); fromItem.classList.add('done');
            fromItem.querySelector('.track-circle').innerHTML = '<i class="fa-solid fa-check"></i>';
            const line = document.getElementById('line-' + currentStep);
            if (line) line.classList.add('done');
        } else if (fromItem && step < currentStep) {
            fromItem.classList.remove('active', 'done');
            fromItem.querySelector('.track-circle').innerHTML = currentStep;
            const line = document.getElementById('line-' + step);
            if (line) line.classList.remove('done');
        }
        const toItem = document.getElementById('track-step-' + step);
        if (toItem) { toItem.classList.add('active'); toItem.classList.remove('done'); toItem.querySelector('.track-circle').innerHTML = step; }

        currentStep = step;
    };

    function populateReview() {
        const date    = document.getElementById('scheduled_date')?.value;
        const time    = document.getElementById('scheduled_time')?.value;
        const address = document.getElementById('address')?.value.trim();
        const paymentEl = document.getElementById('payment_method');
        const notes   = document.getElementById('notes')?.value.trim() || '';
        const total   = [...selectedTests.values()].reduce((s, t) => s + Number(t.price), 0);
        const count   = selectedTests.size;

        const list = document.getElementById('reviewTestsList');
        list.innerHTML = '';
        selectedTests.forEach((t) => {
            const div = document.createElement('div');
            div.className = 'review-test-item';
            div.innerHTML = `<div class="rti-left"><i class="fa-solid fa-flask-vial"></i><div><div class="rti-name">${t.name}</div><div class="rti-cat">${t.category}</div></div></div><div class="rti-price">${fcfa(t.price)}</div>`;
            list.appendChild(div);
        });

        document.getElementById('reviewSubtotal').textContent = fcfa(total);

        const dateFormatted = date ? new Date(date).toLocaleDateString('fr-FR', {weekday:'long',year:'numeric',month:'long',day:'numeric'}) : '—';
        document.getElementById('reviewDate').textContent    = dateFormatted;
        document.getElementById('reviewTime').textContent    = time || '—';
        document.getElementById('reviewAddress').textContent = address || '—';
        document.getElementById('reviewPayment').textContent = paymentEl?.options[paymentEl.selectedIndex]?.text || '—';

        const notesBox = document.getElementById('reviewNotesBox');
        if (notes) { notesBox.style.display='flex'; document.getElementById('reviewNotes').textContent=notes; }
        else { notesBox.style.display='none'; }

        document.getElementById('psTestCount').textContent = count;
        document.getElementById('psSubtotal').textContent  = fcfa(total);
        document.getElementById('psTotal').textContent     = fcfa(total);
    }

    document.getElementById('labBookingForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        if (btn) { btn.disabled=true; btn.innerHTML='<i class="fa-solid fa-spinner fa-spin"></i> Submitting…'; }
    });

    setTimeout(() => {
        const f = document.getElementById('flashMsg');
        if (f) { f.style.opacity='0'; f.style.transition='opacity .4s'; setTimeout(()=>f?.remove(),400); }
    }, 6000);
});
</script>
@endsection