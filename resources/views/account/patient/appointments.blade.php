@extends('layout.index')

@section('content')
<style>
/* ===== DOCTORS LIST PAGE ===== */
.doctors-page {
    padding: 0 0 60px;
    background: #ffffff;
    min-height: 100vh;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

/* ---- Hero Banner ---- */
.doctors-hero {
    background: linear-gradient(135deg, #1a3c6e 0%, #2563eb 60%, #38bdf8 100%);
    border-radius: 20px;
    padding: 48px 40px;
    margin: 28px 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
    position: relative;
}
.doctors-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-text { position: relative; z-index: 1; }
.hero-label {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.15);
    color: #bae6fd;
    font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 14px; border-radius: 20px;
    margin-bottom: 16px;
}
.hero-label::before {
    content: ''; display: inline-block;
    width: 6px; height: 6px; border-radius: 50%;
    background: #38bdf8; animation: pulse-dot 1.5s ease-in-out infinite;
}
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

.doctors-hero h1 {
    font-size: 2.2rem; font-weight: 800; color: #fff; margin: 0 0 8px;
    line-height: 1.2;
}
.doctors-hero h1 span { color: #7dd3fc; }
.doctors-hero p { color: rgba(255,255,255,.75); font-size: 0.95rem; margin: 0; }

.hero-orbs { position: relative; z-index: 1; display: flex; gap: -20px; }
.orb {
    width: 90px; height: 90px; border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    animation: float-orb 3s ease-in-out infinite;
}
.orb:nth-child(2) { animation-delay: -.8s; margin-left: -15px; }
.orb:nth-child(3) { animation-delay: -1.6s; margin-left: -15px; }
@keyframes float-orb { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }

/* ---- Controls: Search + Filter ---- */
.doctors-controls {
    padding: 0 24px 24px;
    display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
}
.search-box {
    flex: 1; min-width: 220px;
    display: flex; align-items: center; gap: 10px;
    background: #f0f7ff;
    border: 1.5px solid #dbeafe;
    border-radius: 12px;
    padding: 10px 16px;
    transition: border-color .2s, box-shadow .2s;
}
.search-box:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
.search-box svg { color: #94a3b8; flex-shrink: 0; }
.search-box input {
    flex: 1; border: none; background: transparent;
    font-size: .95rem; color: #1e293b; outline: none;
}
.search-box input::placeholder { color: #94a3b8; }

.filter-select {
    padding: 10px 16px; border-radius: 12px;
    border: 1.5px solid #dbeafe; background: #f0f7ff;
    font-size: .9rem; color: #1e293b; outline: none; cursor: pointer;
    transition: border-color .2s;
}
.filter-select:focus { border-color: #2563eb; }

/* ---- Doctors Grid ---- */
.doctors-grid {
    padding: 0 24px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.doctor-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e2eaf7;
    box-shadow: 0 2px 12px rgba(37,99,235,.06);
    overflow: hidden;
    transition: transform .25s, box-shadow .25s;
    display: flex; flex-direction: column;
}
.doctor-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(37,99,235,.14);
}

.card-header {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    padding: 28px 20px 20px;
    text-align: center;
    position: relative;
}
.doctor-avatar {
    width: 88px; height: 88px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.4);
    object-fit: cover;
    margin: 0 auto 12px;
    display: block;
    background: rgba(255,255,255,0.15);
}
.doctor-avatar-placeholder {
    width: 88px; height: 88px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.4);
    margin: 0 auto 12px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(255,255,255,0.2);
    font-size: 2.2rem;
}
.card-header h3 {
    color: #fff; font-size: 1.05rem; font-weight: 700; margin: 0 0 4px;
}
.specialty-badge {
    display: inline-block;
    background: rgba(255,255,255,0.18);
    color: #bae6fd;
    font-size: 0.75rem; font-weight: 600; letter-spacing: .5px;
    padding: 3px 12px; border-radius: 20px;
}

.card-body { padding: 16px 18px; flex: 1; }

.doctor-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 14px; }
.meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.8rem; color: #64748b;
}
.meta-item svg { color: #2563eb; }

.slots-info {
    display: flex; align-items: center; gap: 6px;
    margin-bottom: 14px;
}
.slot-count {
    display: inline-flex; align-items: center; gap: 4px;
    background: #f0fdf4; color: #15803d;
    font-size: .78rem; font-weight: 600; padding: 4px 10px; border-radius: 8px;
    border: 1px solid #bbf7d0;
}
.slot-count.no-slots {
    background: #fef2f2; color: #dc2626; border-color: #fecaca;
}

.card-actions { display: flex; gap: 10px; padding: 0 18px 18px; }

.btn-book {
    flex: 1; padding: 10px 0;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: .9rem; font-weight: 600;
    border: none; border-radius: 10px; cursor: pointer;
    transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-book:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: translateY(-1px); }
.btn-book:disabled { background: #cbd5e1; cursor: not-allowed; transform: none; }

.btn-profile {
    padding: 10px 14px;
    background: #f0f7ff; color: #2563eb;
    font-size: .9rem; font-weight: 600;
    border: 1.5px solid #dbeafe; border-radius: 10px; cursor: pointer;
    transition: all .2s;
}
.btn-profile:hover { background: #dbeafe; }

/* ---- Empty State ---- */
.no-doctors {
    grid-column: 1/-1; text-align: center; padding: 60px 20px;
    color: #94a3b8;
}
.no-doctors svg { margin-bottom: 16px; }
.no-doctors h3 { font-size: 1.2rem; color: #64748b; margin: 0 0 6px; }
.no-doctors p { font-size: .9rem; margin: 0; }

/* ---- Booking Modal ---- */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.6); backdrop-filter: blur(4px);
    z-index: 9999; align-items: center; justify-content: center;
    padding: 16px;
}
.modal-overlay.active { display: flex; animation: fade-in .2s ease; }
@keyframes fade-in { from{opacity:0} to{opacity:1} }

.modal-box {
    background: #fff; border-radius: 20px;
    width: 100%; max-width: 520px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: slide-up .25s ease;
    overflow: hidden;
}
@keyframes slide-up { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.modal-header {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    padding: 24px 24px 20px;
    display: flex; align-items: flex-start; justify-content: space-between;
}
.modal-header-info h2 { color: #fff; font-size: 1.15rem; font-weight: 700; margin: 0 0 4px; }
.modal-header-info p { color: rgba(255,255,255,.7); font-size: .85rem; margin: 0; }

.modal-close {
    background: rgba(255,255,255,.15); border: none; color: #fff;
    width: 32px; height: 32px; border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; transition: background .2s; flex-shrink: 0;
}
.modal-close:hover { background: rgba(255,255,255,.25); }

.modal-body { padding: 24px; }

.modal-section-title {
    font-size: .8rem; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: #94a3b8; margin: 0 0 12px;
}

.slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 10px;
    margin-bottom: 20px;
    max-height: 240px; overflow-y: auto;
}
.slot-btn {
    padding: 10px 12px; border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc; cursor: pointer; text-align: left;
    transition: all .2s; display: flex; flex-direction: column; gap: 2px;
}
.slot-btn:hover { border-color: #2563eb; background: #eff6ff; }
.slot-btn.selected { border-color: #2563eb; background: #eff6ff; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
.slot-btn .slot-date { font-size: .75rem; color: #64748b; font-weight: 500; }
.slot-btn .slot-time { font-size: .88rem; color: #1e293b; font-weight: 700; }
.slot-btn .slot-price { font-size: .75rem; color: #2563eb; font-weight: 600; }

.no-slots-msg {
    text-align: center; padding: 30px; color: #94a3b8;
    font-size: .9rem; background: #f8fafc; border-radius: 12px; margin-bottom: 20px;
}

.reason-group { margin-bottom: 20px; }
.reason-group label { display: block; font-size: .85rem; font-weight: 600; color: #475569; margin-bottom: 6px; }
.reason-group textarea {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: .9rem; color: #1e293b; resize: vertical; min-height: 80px;
    font-family: inherit; outline: none; box-sizing: border-box;
    transition: border-color .2s;
}
.reason-group textarea:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.08); }

.modal-footer { display: flex; gap: 10px; padding: 0 24px 24px; }

.btn-confirm {
    flex: 1; padding: 12px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: .95rem; font-weight: 700;
    border: none; border-radius: 12px; cursor: pointer;
    transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-confirm:hover:not(:disabled) { background: linear-gradient(135deg, #1d4ed8, #1e40af); transform: translateY(-1px); }
.btn-confirm:disabled { opacity: .6; cursor: not-allowed; transform: none; }

.btn-cancel {
    padding: 12px 20px;
    background: #f1f5f9; color: #64748b;
    font-size: .95rem; font-weight: 600;
    border: none; border-radius: 12px; cursor: pointer; transition: background .2s;
}
.btn-cancel:hover { background: #e2e8f0; }

/* ---- Success Modal ---- */
.success-modal {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.6); backdrop-filter: blur(4px);
    z-index: 10000; align-items: center; justify-content: center; padding: 16px;
}
.success-modal.active { display: flex; animation: fade-in .2s ease; }
.success-box {
    background: #fff; border-radius: 20px;
    width: 100%; max-width: 400px;
    padding: 40px 32px; text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: slide-up .25s ease;
}
.success-icon {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 2rem;
}
.success-box h3 { font-size: 1.3rem; font-weight: 800; color: #1e293b; margin: 0 0 8px; }
.success-box p { font-size: .9rem; color: #64748b; margin: 0 0 6px; }
.success-details {
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px;
    padding: 16px; margin: 16px 0; text-align: left;
}
.success-details .sd-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: .85rem; padding: 4px 0;
}
.success-details .sd-row span:first-child { color: #64748b; }
.success-details .sd-row span:last-child { color: #1e293b; font-weight: 600; }
.btn-close-success {
    width: 100%; padding: 12px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff; font-size: .95rem; font-weight: 700;
    border: none; border-radius: 12px; cursor: pointer;
    transition: all .2s; margin-top: 8px;
}
.btn-close-success:hover { background: linear-gradient(135deg, #1d4ed8, #1e40af); }

/* ---- Loading spinner ---- */
.spinner {
    width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    animation: spin .6s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="doctors-page">

    {{-- ===== HERO BANNER ===== --}}
    <div class="doctors-hero">
        <div class="hero-text">
            <div class="hero-label">Health Without a Step</div>
            <h1>Find the right <span>specialist</span><br>for your care</h1>
            <p>Browse our certified doctors and book your slot in seconds.</p>
        </div>
        <div class="hero-orbs">
            <div class="orb">🩺</div>
            <div class="orb">💊</div>
            <div class="orb">❤️</div>
        </div>
    </div>

    {{-- ===== SEARCH & FILTER ===== --}}
    <div class="doctors-controls">
        <div class="search-box">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" id="doctorSearch" placeholder="Search doctors by name or specialty…">
        </div>
        <select id="specialtyFilter" class="filter-select">
            <option value="">All Specialties</option>
            @foreach($doctors->pluck('specialty')->unique()->filter()->sort() as $spec)
                <option value="{{ strtolower($spec) }}">{{ $spec }}</option>
            @endforeach
        </select>
        <select id="availabilityFilter" class="filter-select">
            <option value="">All Doctors</option>
            <option value="available">With Available Slots</option>
            <option value="no-slots">No Slots</option>
        </select>
    </div>

    {{-- ===== DOCTORS GRID ===== --}}
    <div class="doctors-grid" id="doctorsGrid">

        @forelse($doctors as $doctor)
        @php
            $availableSlots = $doctor->schedules->count();
            $hasSlots = $availableSlots > 0;
        @endphp
        <div class="doctor-card"
             data-name="{{ strtolower($doctor->doctor_name) }}"
             data-specialty="{{ strtolower($doctor->specialty ?? '') }}"
             data-availability="{{ $hasSlots ? 'available' : 'no-slots' }}">

            <div class="card-header">
                <div class="doctor-avatar-placeholder">👨‍⚕️</div>
                <h3>Dr. {{ $doctor->doctor_name }}</h3>
                <span class="specialty-badge">{{ $doctor->specialty ?? 'General' }}</span>
            </div>

            <div class="card-body">
                <div class="doctor-meta">
                    @if($doctor->qualification)
                    <span class="meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        {{ $doctor->qualification }}
                    </span>
                    @endif
                    @if($doctor->years_of_experience)
                    <span class="meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $doctor->years_of_experience }} yrs exp.
                    </span>
                    @endif
                    @if($doctor->consultation_fee)
                    <span class="meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        {{ number_format($doctor->consultation_fee, 0, '.', ' ') }} FCFA
                    </span>
                    @endif
                </div>

                <div class="slots-info">
                    <span class="slot-count {{ !$hasSlots ? 'no-slots' : '' }}">
                        @if($hasSlots)
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $availableSlots }} slot{{ $availableSlots > 1 ? 's' : '' }} available
                        @else
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            No slots available
                        @endif
                    </span>
                </div>
            </div>

            <div class="card-actions">
                <button class="btn-book" {{ !$hasSlots ? 'disabled' : '' }}
                    onclick='openBookingModal({{ json_encode([
                        "id"       => $doctor->id,
                        "name"     => $doctor->doctor_name,
                        "specialty"=> $doctor->specialty ?? "General",
                        "schedules"=> $doctor->schedules->map(fn($s) => [
                            "id"    => $s->id,
                            "date"  => $s->date?->format("d M Y"),
                            "start" => \Carbon\Carbon::parse($s->start_time)->format("H:i"),
                            "end"   => \Carbon\Carbon::parse($s->end_time)->format("H:i"),
                            "price" => number_format((float)$s->price, 0, ".", " "),
                        ])->toArray()
                    ]) }})'>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Book
                </button>
                <button class="btn-profile" title="View profile (coming soon)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="no-doctors">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <h3>No doctors available</h3>
            <p>Please check back later or contact administration.</p>
        </div>
        @endforelse

        {{-- Hidden "no results" row shown by JS when search yields nothing --}}
        <div class="no-doctors" id="noSearchResults" style="display:none;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <h3>No doctors found</h3>
            <p>Try a different name or specialty.</p>
        </div>
    </div>

</div>

{{-- ===== BOOKING MODAL ===== --}}
<div class="modal-overlay" id="bookingModal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-header-info">
                <h2 id="modalDoctorName">Book Appointment</h2>
                <p id="modalSpecialty"></p>
            </div>
            <button class="modal-close" onclick="closeBookingModal()">✕</button>
        </div>
        <div class="modal-body">
            <p class="modal-section-title">Select a Time Slot</p>
            <div class="slots-grid" id="slotsGrid"></div>
            <div class="no-slots-msg" id="noSlotsMsg" style="display:none;">
                No available slots for this doctor.
            </div>

            <div class="reason-group">
                <label for="bookingReason">Reason for visit <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                <textarea id="bookingReason" placeholder="e.g. Follow-up consultation, chest pain, routine checkup…"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeBookingModal()">Cancel</button>
            <button class="btn-confirm" id="confirmBtn" onclick="submitBooking()" disabled>
                <span id="confirmBtnText">Confirm Booking</span>
            </button>
        </div>
    </div>
</div>

{{-- ===== SUCCESS MODAL ===== --}}
<div class="success-modal" id="successModal">
    <div class="success-box">
        <div class="success-icon">✓</div>
        <h3>Appointment Booked!</h3>
        <p>Your appointment has been confirmed.</p>
        <div class="success-details" id="successDetails"></div>
        <button class="btn-close-success" onclick="closeSuccessModal()">Done</button>
    </div>
</div>

<script>
    const BOOK_URL   = "{{ route('patient.appointment.book') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    let selectedDoctorId  = null;
    let selectedScheduleId = null;

    /* -------- Open / Close Booking Modal -------- */
    function openBookingModal(doctor) {
        selectedDoctorId   = doctor.id;
        selectedScheduleId = null;

        document.getElementById('modalDoctorName').textContent = 'Dr. ' + doctor.name;
        document.getElementById('modalSpecialty').textContent  = doctor.specialty;
        document.getElementById('bookingReason').value         = '';
        document.getElementById('confirmBtn').disabled         = true;
        document.getElementById('confirmBtnText').textContent  = 'Confirm Booking';

        const grid   = document.getElementById('slotsGrid');
        const noMsg  = document.getElementById('noSlotsMsg');
        grid.innerHTML = '';

        if (!doctor.schedules || doctor.schedules.length === 0) {
            grid.style.display = 'none';
            noMsg.style.display = 'block';
        } else {
            noMsg.style.display = 'none';
            grid.style.display  = 'grid';

            doctor.schedules.forEach(slot => {
                const btn = document.createElement('button');
                btn.className = 'slot-btn';
                btn.dataset.id = slot.id;
                btn.innerHTML = `
                    <span class="slot-date">${slot.date}</span>
                    <span class="slot-time">${slot.start} – ${slot.end}</span>
                    <span class="slot-price">${slot.price} FCFA</span>`;
                btn.addEventListener('click', () => selectSlot(btn, slot.id));
                grid.appendChild(btn);
            });
        }

        document.getElementById('bookingModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeBookingModal() {
        document.getElementById('bookingModal').classList.remove('active');
        document.body.style.overflow = '';
        selectedScheduleId = null;
    }

    function selectSlot(btn, scheduleId) {
        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        selectedScheduleId = scheduleId;
        document.getElementById('confirmBtn').disabled = false;
    }

    /* -------- Submit Booking -------- */
    async function submitBooking() {
        if (!selectedDoctorId || !selectedScheduleId) return;

        const confirmBtn = document.getElementById('confirmBtn');
        const btnText    = document.getElementById('confirmBtnText');

        confirmBtn.disabled  = true;
        btnText.innerHTML    = '<div class="spinner"></div> Booking…';

        try {
            const res = await fetch(BOOK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept':       'application/json',
                },
                body: JSON.stringify({
                    doctor_id:   selectedDoctorId,
                    schedule_id: selectedScheduleId,
                    reason:      document.getElementById('bookingReason').value.trim(),
                }),
            });

            const data = await res.json();

            if (data.success) {
                closeBookingModal();
                showSuccess(data);
                // Remove the booked slot button from all cards
                removeBookedSlot(selectedScheduleId);
            } else {
                alert('❌ ' + (data.message || 'Booking failed. Please try again.'));
                confirmBtn.disabled = false;
                btnText.textContent = 'Confirm Booking';
            }
        } catch (err) {
            alert('❌ Network error. Please try again.');
            confirmBtn.disabled = false;
            btnText.textContent = 'Confirm Booking';
        }
    }

    function showSuccess(data) {
        document.getElementById('successDetails').innerHTML = `
            <div class="sd-row"><span>Doctor</span><span>Dr. ${data.doctor_name}</span></div>
            <div class="sd-row"><span>Date</span><span>${data.date}</span></div>
            <div class="sd-row"><span>Time</span><span>${data.time}</span></div>
            <div class="sd-row"><span>Fee</span><span>${data.fee}</span></div>
            <div class="sd-row"><span>Status</span><span style="color:#15803d">✓ Confirmed</span></div>`;
        document.getElementById('successModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function removeBookedSlot(scheduleId) {
        // If a card now has 0 slots, update its button state
        // (Full refresh would be cleanest; we'll just reload)
        // Give a brief moment so the success modal is visible first
        setTimeout(() => location.reload(), 2500);
    }

    /* -------- Search & Filter -------- */
    function applyFilters() {
        const search       = document.getElementById('doctorSearch').value.toLowerCase();
        const specialty    = document.getElementById('specialtyFilter').value;
        const availability = document.getElementById('availabilityFilter').value;

        let visible = 0;
        document.querySelectorAll('#doctorsGrid .doctor-card').forEach(card => {
            const nameMatch = card.dataset.name.includes(search);
            const specMatch = card.dataset.specialty.includes(search);
            const filterSpec = !specialty || card.dataset.specialty === specialty;
            const filterAvail = !availability || card.dataset.availability === availability;

            if ((nameMatch || specMatch) && filterSpec && filterAvail) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('noSearchResults').style.display = visible === 0 ? 'flex' : 'none';
    }

    document.getElementById('doctorSearch').addEventListener('input', applyFilters);
    document.getElementById('specialtyFilter').addEventListener('change', applyFilters);
    document.getElementById('availabilityFilter').addEventListener('change', applyFilters);

    /* -------- Close modal on overlay click -------- */
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) closeBookingModal();
    });
    document.getElementById('successModal').addEventListener('click', function(e) {
        if (e.target === this) closeSuccessModal();
    });
</script>
@endsection