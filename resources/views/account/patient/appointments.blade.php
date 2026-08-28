@extends('layout.index')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

/* ================================================================
   DOCTORS LIST PAGE
================================================================ */
.dl-page {
    background: #ffffff;
    min-height: 100vh;
    font-family: 'Inter', 'Segoe UI', sans-serif;
    padding-bottom: 64px;
}

/* ---- Hero ---- */
.dl-hero {
    background: linear-gradient(120deg, #1e3a8a 0%, #2563eb 100%);
    padding: 36px 40px 34px;
    margin: 0 32px 28px;
    border-radius: 18px;
}
.dl-hero-tag {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    color: #bae6fd;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 12px;
}
.dl-hero h1 {
    color: #fff;
    font-size: 1.9rem;
    font-weight: 800;
    margin: 0 0 7px;
    line-height: 1.25;
}
.dl-hero h1 span { color: #7dd3fc; }
.dl-hero p { color: rgba(255,255,255,0.70); font-size: .9rem; margin: 0; }

/* ---- Controls ---- */
.dl-controls {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    padding: 0 32px 24px;
}
.dl-search {
    flex: 1; min-width: 190px;
    display: flex; align-items: center; gap: 9px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 14px;
    transition: border-color .2s, box-shadow .2s;
}
.dl-search:focus-within { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
.dl-search svg { color: #94a3b8; flex-shrink: 0; }
.dl-search input { flex: 1; border: none; background: transparent; font-size: .9rem; color: #0f172a; outline: none; }
.dl-search input::placeholder { color: #94a3b8; }
.dl-select {
    padding: 9px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    font-size: .86rem;
    color: #334155;
    outline: none; cursor: pointer;
    transition: border-color .2s;
}
.dl-select:focus { border-color: #2563eb; }

/* ---- Grid ---- */
.dl-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(265px, 1fr));
    gap: 20px;
    padding: 0 32px;
}

/* ---- Doctor Card ---- */
.dl-card {
    background: #ffffff;
    border: 1px solid #e9eef5;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .22s, box-shadow .22s;
}
.dl-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(37,99,235,.11); }

.dl-card-img {
    width: 100%; height: 195px;
    object-fit: cover; object-position: top center;
    display: block; background: #f1f5f9;
}
.dl-card-img-placeholder {
    width: 100%; height: 195px;
    background: linear-gradient(135deg, #dbeafe, #eff6ff);
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem;
}
.dl-card-body { padding: 16px 18px 12px; flex: 1; display: flex; flex-direction: column; gap: 5px; }
.dl-card-name { font-size: .98rem; font-weight: 700; color: #0f172a; margin: 0; }
.dl-card-spec {
    display: inline-block;
    background: #eff6ff; color: #2563eb;
    font-size: .7rem; font-weight: 700;
    letter-spacing: .5px; text-transform: uppercase;
    padding: 3px 9px; border-radius: 5px; width: fit-content;
}
.dl-card-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 3px; }
.dl-meta-item { display: flex; align-items: center; gap: 4px; font-size: .75rem; color: #64748b; }
.dl-meta-item svg { color: #2563eb; }
.dl-slot-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .72rem; font-weight: 600;
    padding: 3px 9px; border-radius: 6px;
    width: fit-content; margin-top: 5px;
}
.dl-slot-badge.has { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.dl-slot-badge.none { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

.dl-card-footer { padding: 0 18px 16px; }
.dl-btn-book {
    width: 100%; padding: 10px 0;
    background: #2563eb; color: #fff;
    font-size: .88rem; font-weight: 700;
    border: none; border-radius: 9px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: background .18s, transform .18s;
}
.dl-btn-book:hover:not(:disabled) { background: #1d4ed8; transform: translateY(-1px); }
.dl-btn-book:disabled { background: #cbd5e1; cursor: not-allowed; }

.dl-empty { grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #94a3b8; }
.dl-empty h3 { font-size: 1.05rem; color: #64748b; margin: 10px 0 3px; }
.dl-empty p { font-size: .85rem; margin: 0; }

/* ================================================================
   MULTI-STEP BOOKING MODAL
================================================================ */
.ms-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(15,23,42,.58);
    backdrop-filter: blur(5px);
    z-index: 9000;
    align-items: center; justify-content: center;
    padding: 16px;
}
.ms-overlay.open { display: flex; animation: ms-fade .18s ease; }
@keyframes ms-fade { from{opacity:0}to{opacity:1} }

.ms-box {
    background: #fff;
    border-radius: 20px;
    width: 100%; max-width: 560px;
    box-shadow: 0 24px 56px rgba(0,0,0,.18);
    animation: ms-up .22s ease;
    overflow: hidden;
    display: flex; flex-direction: column;
}
@keyframes ms-up { from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)} }

/* --- Progress bar header --- */
.ms-header {
    background: linear-gradient(120deg,#1e3a8a,#2563eb);
    padding: 20px 24px 0;
}
.ms-header-top {
    display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 18px;
}
.ms-header-info h2 { color:#fff; font-size:1.05rem; font-weight:700; margin:0 0 2px; }
.ms-header-info p  { color:rgba(255,255,255,.65); font-size:.8rem; margin:0; }
.ms-close {
    background: rgba(255,255,255,.15); border:none; color:#fff;
    width:30px; height:30px; border-radius:7px; cursor:pointer;
    font-size:1rem; display:flex; align-items:center; justify-content:center;
    transition:background .18s; flex-shrink:0;
}
.ms-close:hover { background:rgba(255,255,255,.28); }

/* Steps tracker */
.ms-steps {
    display: flex; gap: 0;
    border-bottom: 3px solid rgba(255,255,255,0.15);
}
.ms-step {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    padding: 10px 0 12px;
    font-size: .75rem; font-weight: 600;
    color: rgba(255,255,255,.45);
    border-bottom: 3px solid transparent;
    margin-bottom: -3px;
    transition: color .25s, border-color .25s;
    cursor: default;
}
.ms-step.active { color: #fff; border-bottom-color: #fff; }
.ms-step.done   { color: rgba(255,255,255,.75); }
.ms-step-num {
    width: 22px; height: 22px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700;
    transition: background .25s, border-color .25s;
}
.ms-step.active .ms-step-num { background: #fff; color: #2563eb; border-color: #fff; }
.ms-step.done   .ms-step-num { background: rgba(255,255,255,.2); border-color:rgba(255,255,255,.4); }

/* --- Step panels --- */
.ms-panel { display:none; padding:22px 24px; }
.ms-panel.active { display:block; }

.ms-section-label {
    font-size:.7rem; font-weight:700; letter-spacing:1.2px;
    text-transform:uppercase; color:#94a3b8; margin:0 0 10px;
}

/* Slot grid */
.ms-slots {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px,1fr));
    gap: 9px;
    max-height: 220px;
    overflow-y: auto;
    margin-bottom: 6px;
}
.ms-slot {
    padding:10px 12px; border:1.5px solid #e2e8f0; border-radius:10px;
    background:#f8fafc; cursor:pointer; text-align:left;
    transition:border-color .18s, background .18s;
    display:flex; flex-direction:column; gap:2px;
}
.ms-slot:hover { border-color:#2563eb; background:#eff6ff; }
.ms-slot.sel   { border-color:#2563eb; background:#eff6ff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.ms-slot-date  { font-size:.7rem; color:#64748b; font-weight:500; }
.ms-slot-time  { font-size:.85rem; color:#0f172a; font-weight:700; }
.ms-slot-price { font-size:.7rem; color:#2563eb; font-weight:600; }

.ms-no-slots {
    text-align:center; padding:24px; background:#f8fafc;
    border-radius:10px; color:#94a3b8; font-size:.86rem; margin-bottom:6px;
}

/* Step 2 – details */
.ms-form-group { margin-bottom:16px; }
.ms-form-group label { display:block; font-size:.82rem; font-weight:600; color:#475569; margin-bottom:6px; }
.ms-form-group textarea {
    width:100%; padding:10px 13px;
    border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:.88rem; color:#0f172a; resize:vertical; min-height:70px;
    font-family:inherit; outline:none; box-sizing:border-box;
    transition:border-color .18s;
}
.ms-form-group textarea:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.07); }

/* Payment methods */
.ms-pay-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:4px; }
.ms-pay-option {
    border:1.5px solid #e2e8f0; border-radius:12px;
    padding:14px 12px; cursor:pointer; text-align:center;
    transition:border-color .18s, background .18s;
    display:flex; flex-direction:column; align-items:center; gap:6px;
}
.ms-pay-option:hover { border-color:#2563eb; background:#f0f7ff; }
.ms-pay-option.sel { border-color:#2563eb; background:#eff6ff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.ms-pay-icon { font-size:1.6rem; }
.ms-pay-label { font-size:.78rem; font-weight:700; color:#334155; }
.ms-pay-desc { font-size:.68rem; color:#94a3b8; line-height:1.3; }

/* Step 3 – confirmation summary */
.ms-summary {
    background:#f8fafc; border:1px solid #e2e8f0;
    border-radius:12px; padding:16px 18px;
    margin-bottom:16px;
}
.ms-sum-row {
    display:flex; justify-content:space-between;
    font-size:.84rem; padding:5px 0;
    border-bottom:1px solid #f1f5f9;
}
.ms-sum-row:last-child { border-bottom:none; }
.ms-sum-row span:first-child { color:#64748b; }
.ms-sum-row span:last-child { color:#0f172a; font-weight:600; }
.ms-sum-total {
    display:flex; justify-content:space-between;
    font-size:.95rem; font-weight:800;
    color:#0f172a; margin-top:10px;
    padding-top:10px; border-top:2px solid #e2e8f0;
}
.ms-sum-total span:last-child { color:#2563eb; }

.ms-pay-notice {
    display:flex; align-items:flex-start; gap:8px;
    background:#fffbeb; border:1px solid #fcd34d;
    border-radius:10px; padding:12px 14px;
    font-size:.78rem; color:#92400e; line-height:1.4;
    margin-bottom:4px;
}
.ms-pay-notice svg { flex-shrink:0; margin-top:1px; }

/* Footer nav */
.ms-footer {
    display:flex; justify-content:space-between; align-items:center;
    padding:14px 24px 20px; border-top:1px solid #f1f5f9;
    gap:10px;
}
.ms-btn-back {
    padding:10px 18px;
    background:#f1f5f9; color:#64748b;
    font-size:.88rem; font-weight:600;
    border:none; border-radius:10px; cursor:pointer; transition:background .18s;
}
.ms-btn-back:hover { background:#e2e8f0; }
.ms-btn-next {
    flex:1; max-width:220px;
    padding:10px 0;
    background:#2563eb; color:#fff;
    font-size:.9rem; font-weight:700;
    border:none; border-radius:10px; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:7px;
    transition:background .18s, transform .18s;
}
.ms-btn-next:hover:not(:disabled) { background:#1d4ed8; transform:translateY(-1px); }
.ms-btn-next:disabled { opacity:.55; cursor:not-allowed; transform:none; }

/* ================================================================
   SUCCESS MODAL
================================================================ */
.sm-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(15,23,42,.58); backdrop-filter:blur(5px);
    z-index:9200; align-items:center; justify-content:center; padding:16px;
}
.sm-overlay.open { display:flex; animation:ms-fade .18s ease; }
.sm-box {
    background:#fff; border-radius:20px;
    width:100%; max-width:380px; padding:36px 30px;
    text-align:center; box-shadow:0 24px 56px rgba(0,0,0,.18);
    animation:ms-up .22s ease;
}
.sm-icon {
    width:68px; height:68px; border-radius:50%;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 18px; font-size:1.7rem; color:#fff;
}
.sm-box h3 { font-size:1.2rem; font-weight:800; color:#0f172a; margin:0 0 5px; }
.sm-box > p { font-size:.86rem; color:#64748b; margin:0 0 16px; }
.sm-details {
    background:#f0fdf4; border:1px solid #bbf7d0;
    border-radius:12px; padding:14px 16px;
    text-align:left; margin-bottom:18px;
}
.sm-row { display:flex; justify-content:space-between; font-size:.82rem; padding:3px 0; }
.sm-row span:first-child { color:#64748b; }
.sm-row span:last-child { color:#0f172a; font-weight:600; }
.sm-btn {
    width:100%; padding:12px;
    background:#2563eb; color:#fff;
    font-size:.92rem; font-weight:700;
    border:none; border-radius:10px; cursor:pointer; transition:background .18s;
}
.sm-btn:hover { background:#1d4ed8; }

/* spinner */
.spin {
    width:15px; height:15px;
    border:2px solid rgba(255,255,255,.3);
    border-top-color:#fff; border-radius:50%;
    animation:spinning .55s linear infinite;
}
@keyframes spinning { to { transform:rotate(360deg); } }
</style>

@php
    $docImages = ['image/doc.png','image/doc2.jpg','image/doc3.jpg','image/download.jpg'];
@endphp

<div class="dl-page">

    {{-- ===== HERO ===== --}}
    <div class="dl-hero">
        <div class="dl-hero-tag">Book an Appointment</div>
        <h1>Find the right <span>specialist</span><br>for your care</h1>
        <p>Browse certified doctors and book a slot — fast, easy, secure.</p>
    </div>

    {{-- ===== CONTROLS ===== --}}
    <div class="dl-controls">
        <div class="dl-search">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" id="dlSearch" placeholder="Search by name or specialty…">
        </div>
        <select id="dlSpec" class="dl-select">
            <option value="">All Specialties</option>
            @foreach($doctors->pluck('specialty')->unique()->filter()->sort()->values() as $sp)
                <option value="{{ strtolower($sp) }}">{{ $sp }}</option>
            @endforeach
        </select>
        <select id="dlAvail" class="dl-select">
            <option value="">All Doctors</option>
            <option value="1">Available Slots</option>
            <option value="0">No Slots</option>
        </select>
    </div>

    {{-- ===== DOCTORS GRID ===== --}}
    <div class="dl-grid" id="dlGrid">

        @forelse($doctors as $doctor)
        @php
            $cnt    = $doctor->schedules->count();
            $has    = $cnt > 0;
            $imgSrc = $docImages[($doctor->id - 1) % count($docImages)];
        @endphp
        <div class="dl-card"
             data-name="{{ strtolower($doctor->doctor_name) }}"
             data-specialty="{{ strtolower($doctor->specialty ?? '') }}"
             data-avail="{{ $has ? 1 : 0 }}">

            <img src="{{ asset($imgSrc) }}" alt="Dr. {{ $doctor->doctor_name }}"
                 class="dl-card-img"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="dl-card-img-placeholder" style="display:none;">👨‍⚕️</div>

            <div class="dl-card-body">
                <p class="dl-card-name">Dr. {{ $doctor->doctor_name }}</p>
                <span class="dl-card-spec">{{ $doctor->specialty ?? 'General' }}</span>

                <div class="dl-card-meta">
                    @if($doctor->qualification)
                    <span class="dl-meta-item">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        {{ $doctor->qualification }}
                    </span>
                    @endif
                    @if($doctor->years_of_experience)
                    <span class="dl-meta-item">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $doctor->years_of_experience }} yrs
                    </span>
                    @endif
                    @if($doctor->consultation_fee)
                    <span class="dl-meta-item">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        {{ number_format((float)$doctor->consultation_fee,0,'.',' ') }} FCFA
                    </span>
                    @endif
                </div>

                <span class="dl-slot-badge {{ $has ? 'has' : 'none' }}">
                    @if($has)
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $cnt }} slot{{ $cnt > 1 ? 's' : '' }} available
                    @else
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        No slots
                    @endif
                </span>
            </div>

            <div class="dl-card-footer">
                <button class="dl-btn-book" {{ !$has ? 'disabled' : '' }}
                    onclick='startBooking({{ json_encode([
                        "id"        => $doctor->id,
                        "name"      => $doctor->doctor_name,
                        "specialty" => $doctor->specialty ?? "General",
                        "fee"       => number_format((float)$doctor->consultation_fee,0,"."," "),
                        "schedules" => $doctor->schedules->map(fn($s) => [
                            "id"    => $s->id,
                            "date"  => $s->date?->format("d M Y"),
                            "start" => \Carbon\Carbon::parse($s->start_time)->format("H:i"),
                            "end"   => \Carbon\Carbon::parse($s->end_time)->format("H:i"),
                            "price" => number_format((float)$s->price,0,"."," "),
                        ])->toArray()
                    ]) }})'>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Book Appointment
                </button>
            </div>
        </div>

        @empty
        <div class="dl-empty">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.4">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <h3>No doctors available</h3>
            <p>Please check back later or contact administration.</p>
        </div>
        @endforelse

        <div class="dl-empty" id="dlNoResults" style="display:none;">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.4">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <h3>No doctors found</h3>
            <p>Try a different name or filter.</p>
        </div>
    </div>
</div>

{{-- ================================================================
     MULTI-STEP BOOKING MODAL
================================================================ --}}
<div class="ms-overlay" id="msOverlay">
    <div class="ms-box">

        {{-- Header + step progress --}}
        <div class="ms-header">
            <div class="ms-header-top">
                <div class="ms-header-info">
                    <h2 id="msDocName">Book Appointment</h2>
                    <p id="msDocSpec"></p>
                </div>
                <button class="ms-close" onclick="closeModal()">✕</button>
            </div>
            <div class="ms-steps">
                <div class="ms-step active" id="msStep1Tab">
                    <div class="ms-step-num">1</div>
                    <span>Select Slot</span>
                </div>
                <div class="ms-step" id="msStep2Tab">
                    <div class="ms-step-num">2</div>
                    <span>Visit Details</span>
                </div>
                <div class="ms-step" id="msStep3Tab">
                    <div class="ms-step-num">3</div>
                    <span>Payment</span>
                </div>
            </div>
        </div>

        {{-- STEP 1: Select time slot --}}
        <div class="ms-panel active" id="msPanelStep1">
            <p class="ms-section-label">Available time slots</p>
            <div class="ms-slots" id="msSlotsGrid"></div>
            <div class="ms-no-slots" id="msNoSlots" style="display:none;">
                No available slots for this doctor.
            </div>
        </div>

        {{-- STEP 2: Reason + payment choice --}}
        <div class="ms-panel" id="msPanelStep2">
            <div class="ms-form-group">
                <label for="msReason">Reason for visit <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                <textarea id="msReason" placeholder="e.g. Routine checkup, chest pain, follow-up…"></textarea>
            </div>

            <p class="ms-section-label" style="margin-top:4px;">Payment method</p>
            <div class="ms-pay-grid" id="msPayGrid">
                <div class="ms-pay-option sel" data-method="cash" onclick="selectPayment(this,'cash')">
                    <div class="ms-pay-icon">💵</div>
                    <div class="ms-pay-label">Cash</div>
                    <div class="ms-pay-desc">Pay at the clinic on arrival</div>
                </div>
                <div class="ms-pay-option" data-method="mobile_money" onclick="selectPayment(this,'mobile_money')">
                    <div class="ms-pay-icon">📱</div>
                    <div class="ms-pay-label">Mobile Money</div>
                    <div class="ms-pay-desc">MTN MoMo / Orange Money</div>
                </div>
                <div class="ms-pay-option" data-method="bank_transfer" onclick="selectPayment(this,'bank_transfer')">
                    <div class="ms-pay-icon">🏦</div>
                    <div class="ms-pay-label">Bank Transfer</div>
                    <div class="ms-pay-desc">Direct bank payment</div>
                </div>
                <div class="ms-pay-option" data-method="insurance" onclick="selectPayment(this,'insurance')">
                    <div class="ms-pay-icon">🛡️</div>
                    <div class="ms-pay-label">Insurance</div>
                    <div class="ms-pay-desc">Health insurance coverage</div>
                </div>
            </div>
        </div>

        {{-- STEP 3: Confirm & summary --}}
        <div class="ms-panel" id="msPanelStep3">
            <p class="ms-section-label">Booking summary</p>
            <div class="ms-summary" id="msSummary"></div>

            <div class="ms-pay-notice">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span id="msPayNotice">Payment will be collected at the clinic on arrival.</span>
            </div>
        </div>

        {{-- Footer navigation --}}
        <div class="ms-footer">
            <button class="ms-btn-back" id="msBtnBack" onclick="prevStep()" style="display:none;">
                ← Back
            </button>
            <div style="flex:1;"></div>
            <button class="ms-btn-next" id="msBtnNext" onclick="nextStep()" disabled>
                <span id="msBtnNextTxt">Next</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- SUCCESS MODAL --}}
<div class="sm-overlay" id="smOverlay">
    <div class="sm-box">
        <div class="sm-icon">✓</div>
        <h3>Appointment Confirmed!</h3>
        <p>Your booking has been successfully registered.</p>
        <div class="sm-details" id="smDetails"></div>
        <button class="sm-btn" onclick="closeSuccess()">Done</button>
    </div>
</div>

<script>
const BOOK_URL = "{{ route('patient.appointment.book') }}";
const CSRF     = "{{ csrf_token() }}";

/* ---- State ---- */
let doctor      = null;
let selectedSlot = null;   // { id, date, start, end, price }
let selectedPay  = 'cash';
let currentStep  = 1;

/* ============================================================
   OPEN / CLOSE
============================================================ */
function startBooking(doc) {
    doctor       = doc;
    selectedSlot = null;
    selectedPay  = 'cash';
    currentStep  = 1;

    document.getElementById('msDocName').textContent = 'Dr. ' + doc.name;
    document.getElementById('msDocSpec').textContent = doc.specialty;
    document.getElementById('msReason').value        = '';

    // Reset payment selection
    document.querySelectorAll('.ms-pay-option').forEach(o => o.classList.remove('sel'));
    document.querySelector('[data-method="cash"]').classList.add('sel');

    // Build slots
    const grid  = document.getElementById('msSlotsGrid');
    const noMsg = document.getElementById('msNoSlots');
    grid.innerHTML = '';

    if (!doc.schedules || doc.schedules.length === 0) {
        grid.style.display = 'none'; noMsg.style.display = 'block';
    } else {
        noMsg.style.display = 'none'; grid.style.display = 'grid';
        doc.schedules.forEach(s => {
            const btn = document.createElement('button');
            btn.className   = 'ms-slot';
            btn.dataset.slot = JSON.stringify(s);
            btn.innerHTML = `
                <span class="ms-slot-date">${s.date}</span>
                <span class="ms-slot-time">${s.start} – ${s.end}</span>
                <span class="ms-slot-price">${s.price} FCFA</span>`;
            btn.addEventListener('click', () => pickSlot(btn, s));
            grid.appendChild(btn);
        });
    }

    goToStep(1);
    document.getElementById('msOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('msOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ============================================================
   STEP NAVIGATION
============================================================ */
function goToStep(step) {
    currentStep = step;

    // Panels
    [1,2,3].forEach(n => {
        document.getElementById(`msPanelStep${n}`).classList.toggle('active', n === step);
    });

    // Tabs
    [1,2,3].forEach(n => {
        const tab = document.getElementById(`msStep${n}Tab`);
        tab.classList.toggle('active', n === step);
        tab.classList.toggle('done', n < step);
    });

    // Back button
    document.getElementById('msBtnBack').style.display = step > 1 ? 'block' : 'none';

    // Next button
    const nextBtn = document.getElementById('msBtnNext');
    const nextTxt = document.getElementById('msBtnNextTxt');

    if (step === 1) {
        nextBtn.disabled = !selectedSlot;
        nextTxt.textContent = 'Next';
        nextBtn.querySelector('svg').style.display = '';
    } else if (step === 2) {
        nextBtn.disabled = false;
        nextTxt.textContent = 'Review Booking';
        nextBtn.querySelector('svg').style.display = '';
    } else {
        nextBtn.disabled = false;
        nextTxt.innerHTML = 'Confirm Booking';
        nextBtn.querySelector('svg').style.display = 'none';
    }

    // Build summary on step 3
    if (step === 3) buildSummary();
}

function nextStep() {
    if (currentStep === 3) { submitBooking(); return; }
    goToStep(currentStep + 1);
}
function prevStep() {
    if (currentStep > 1) goToStep(currentStep - 1);
}

/* ============================================================
   SLOT & PAYMENT SELECTION
============================================================ */
function pickSlot(btn, slot) {
    document.querySelectorAll('.ms-slot').forEach(b => b.classList.remove('sel'));
    btn.classList.add('sel');
    selectedSlot = slot;
    if (currentStep === 1) {
        document.getElementById('msBtnNext').disabled = false;
    }
}

function selectPayment(el, method) {
    document.querySelectorAll('.ms-pay-option').forEach(o => o.classList.remove('sel'));
    el.classList.add('sel');
    selectedPay = method;
}

/* ============================================================
   SUMMARY BUILD
============================================================ */
function buildSummary() {
    const payLabels = {
        'cash':          '💵 Cash on arrival',
        'mobile_money':  '📱 Mobile Money',
        'bank_transfer': '🏦 Bank Transfer',
        'insurance':     '🛡️ Insurance',
    };
    const notices = {
        'cash':          'Payment will be collected at the clinic on arrival.',
        'mobile_money':  'You will receive payment instructions via SMS after confirmation.',
        'bank_transfer': 'Bank transfer details will be sent to your registered email.',
        'insurance':     'Present your insurance card at the reception desk.',
    };

    document.getElementById('msSummary').innerHTML = `
        <div class="ms-sum-row"><span>Doctor</span><span>Dr. ${doctor.name}</span></div>
        <div class="ms-sum-row"><span>Specialty</span><span>${doctor.specialty}</span></div>
        <div class="ms-sum-row"><span>Date</span><span>${selectedSlot.date}</span></div>
        <div class="ms-sum-row"><span>Time</span><span>${selectedSlot.start} – ${selectedSlot.end}</span></div>
        <div class="ms-sum-row"><span>Reason</span><span>${document.getElementById('msReason').value.trim() || '—'}</span></div>
        <div class="ms-sum-total"><span>Consultation Fee</span><span>${selectedSlot.price} FCFA</span></div>`;

    document.getElementById('msPayNotice').textContent = notices[selectedPay];
    const nextTxt = document.getElementById('msBtnNextTxt');
    nextTxt.textContent = `Confirm — ${payLabels[selectedPay]}`;
}

/* ============================================================
   SUBMIT
============================================================ */
async function submitBooking() {
    const btn = document.getElementById('msBtnNext');
    const txt = document.getElementById('msBtnNextTxt');
    btn.disabled  = true;
    txt.innerHTML = '<div class="spin"></div> Booking…';

    try {
        const res  = await fetch(BOOK_URL, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json' },
            body: JSON.stringify({
                doctor_id:      doctor.id,
                schedule_id:    selectedSlot.id,
                reason:         document.getElementById('msReason').value.trim(),
                payment_method: selectedPay,
            }),
        });
        const data = await res.json();

        if (data.success) {
            closeModal();
            showSuccess(data);
        } else {
            alert('❌ ' + (data.message || 'Booking failed. Please try again.'));
            btn.disabled = false;
            buildSummary();
            const t = document.getElementById('msBtnNextTxt');
            t.textContent = 'Confirm Booking';
        }
    } catch {
        alert('❌ Network error. Please try again.');
        btn.disabled = false;
        txt.textContent = 'Confirm Booking';
    }
}

/* ============================================================
   SUCCESS
============================================================ */
function showSuccess(data) {
    document.getElementById('smDetails').innerHTML = `
        <div class="sm-row"><span>Doctor</span><span>Dr. ${data.doctor_name}</span></div>
        <div class="sm-row"><span>Date</span><span>${data.date}</span></div>
        <div class="sm-row"><span>Time</span><span>${data.time}</span></div>
        <div class="sm-row"><span>Fee</span><span>${data.fee}</span></div>
        <div class="sm-row"><span>Status</span><span style="color:#16a34a;font-weight:700;">✓ Confirmed</span></div>`;
    document.getElementById('smOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => location.reload(), 3000);
}

function closeSuccess() {
    document.getElementById('smOverlay').classList.remove('open');
    document.body.style.overflow = '';
    location.reload();
}

/* ============================================================
   SEARCH & FILTER
============================================================ */
function applyFilters() {
    const q     = document.getElementById('dlSearch').value.toLowerCase();
    const spec  = document.getElementById('dlSpec').value;
    const avail = document.getElementById('dlAvail').value;
    let visible = 0;
    document.querySelectorAll('#dlGrid .dl-card').forEach(card => {
        const ok = (card.dataset.name.includes(q) || card.dataset.specialty.includes(q))
                && (!spec  || card.dataset.specialty === spec)
                && (avail === '' || card.dataset.avail === avail);
        card.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    document.getElementById('dlNoResults').style.display = visible === 0 ? 'block' : 'none';
}
document.getElementById('dlSearch').addEventListener('input', applyFilters);
document.getElementById('dlSpec').addEventListener('change', applyFilters);
document.getElementById('dlAvail').addEventListener('change', applyFilters);

/* close modals on overlay click */
document.getElementById('msOverlay').addEventListener('click', e => { if(e.target.id==='msOverlay') closeModal(); });
document.getElementById('smOverlay').addEventListener('click', e => { if(e.target.id==='smOverlay') closeSuccess(); });
</script>
@endsection