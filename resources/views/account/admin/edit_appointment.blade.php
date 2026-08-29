@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:14px;color:#64748b;">
        <a href="{{ route('admin.dashboard') }}" style="color:#095eff;text-decoration:none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <a href="{{ route('admin.appointments.index') }}" style="color:#095eff;text-decoration:none;">Appointments</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <span style="color:#1e293b;font-weight:600;">Edit Schedule #{{ $schedule->id }}</span>
    </div>

    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-title" style="margin-bottom:6px;font-size:26px;font-weight:700;color:#0f172a;">
                Edit Appointment Schedule
            </h1>
            <p class="page-subtitle" style="margin:0;color:#64748b;font-size:15px;">
                Update doctor assignment, modify consultation hours, or change pricing.
            </p>
        </div>

        <a href="{{ route('admin.appointments.index') }}" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 18px;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-size:14px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Appointments
        </a>
    </div>

    {{-- ERROR ALERTS --}}
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger" style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:16px;border-radius:10px;margin-bottom:24px;">
            <strong style="display:flex;align-items:center;gap:8px;margin-bottom:8px;font-size:15px;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;"></i> Please correct the following errors:
            </strong>
            <ul style="margin:0;padding-left:22px;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom:4px;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,0.04);padding:32px;max-width:960px;margin:0 auto 40px auto;">

                <form method="POST" action="{{ route('admin.appointments.update', $schedule->id) }}" id="appointmentEditForm">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: DOCTOR & PRICE -->
                    <div style="margin-bottom:30px;">
                        <h3 style="font-size:17px;font-weight:700;color:#1e293b;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                            <span style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:#095eff;color:#fff;font-size:13px;">1</span>
                            Doctor & Pricing
                        </h3>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
                            
                            <div style="grid-column:1/-1;">
                                <label for="doctor_id" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                                    Doctor Assigned <span style="color:#ef4444;">*</span>
                                </label>

                                <select id="doctor_id" name="doctor_id" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                                    @foreach($doctors as $doctor)
                                        <option
                                            value="{{ $doctor->id }}"
                                            data-fee="{{ $doctor->consultation_fee }}"
                                            data-specialty="{{ $doctor->specialty }}"
                                            data-name="{{ $doctor->doctor_name }}"
                                            {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}
                                        >
                                            Dr. {{ $doctor->doctor_name }} ({{ $doctor->specialty }} - Standard: {{ number_format($doctor->consultation_fee, 0, ',', ' ') }} XAF) [{{ ucfirst($doctor->status) }}]
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="price" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                                    Appointment Price (XAF) <span style="color:#ef4444;">*</span>
                                </label>

                                <div style="position:relative;">
                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        min="0"
                                        step="100"
                                        value="{{ old('price', $schedule->price ?? $schedule->doctor?->consultation_fee ?? 0) }}"
                                        required
                                        style="width:100%;padding:12px 60px 12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                                    >
                                    <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748b;font-weight:700;font-size:14px;pointer-events:none;">
                                        XAF
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label for="status" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                                    Availability Status <span style="color:#ef4444;">*</span>
                                </label>

                                <select id="status" name="status" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                                    <option value="available" {{ old('status', $schedule->status) === 'available' || old('status', $schedule->status) === 'active' ? 'selected' : '' }}>
                                        Available (Open for booking)
                                    </option>
                                    <option value="unavailable" {{ old('status', $schedule->status) === 'unavailable' || old('status', $schedule->status) === 'inactive' ? 'selected' : '' }}>
                                        Unavailable (Closed)
                                    </option>
                                    <option value="booked" {{ old('status', $schedule->status) === 'booked' ? 'selected' : '' }}>
                                        Booked
                                    </option>
                                </select>
                            </div>

                            <div style="grid-column:1/-1;">
                                <label for="reason" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                                    Consultation Type / Reason
                                </label>

                                <input
                                    type="text"
                                    id="reason"
                                    name="reason"
                                    placeholder="e.g. General Consultation, Follow-up"
                                    value="{{ old('reason', $schedule->reason) }}"
                                    style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                                >
                            </div>

                        </div>
                    </div>

                    <hr style="border:none;border-top:1px solid #e2e8f0;margin:30px 0;">

                    <!-- SECTION 2: AVAILABLE HOURS -->
                    <div style="margin-bottom:30px;">
                        
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
                            <div>
                                <h3 style="font-size:17px;font-weight:700;color:#1e293b;margin:0 0 4px 0;display:flex;align-items:center;gap:8px;">
                                    <span style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:#095eff;color:#fff;font-size:13px;">2</span>
                                    Doctor's Available Hours <span style="color:#ef4444;">*</span>
                                </h3>
                                <p style="margin:0;font-size:13px;color:#64748b;">
                                    Current schedule span: <strong>{{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }}</strong>
                                </p>
                            </div>

                            <span id="selectedCountBadge" style="background:#dbeafe;color:#1e40af;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;">
                                <i class="fa-regular fa-clock"></i> <span id="countText">0 hours selected</span>
                            </span>
                        </div>

                        <!-- Quick Action Presets -->
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;background:#f8fafc;padding:12px 16px;border-radius:8px;border:1px solid #e2e8f0;align-items:center;">
                            <span style="font-size:13px;font-weight:600;color:#475569;">Quick Selection:</span>
                            
                            <button type="button" class="btn-time-preset" data-preset="morning" style="background:#ffffff;border:1px solid #cbd5e1;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                                <i class="fa-regular fa-sun"></i> Morning (08:00 - 12:00)
                            </button>

                            <button type="button" class="btn-time-preset" data-preset="afternoon" style="background:#ffffff;border:1px solid #cbd5e1;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                                <i class="fa-regular fa-cloud-sun"></i> Afternoon (13:00 - 17:00)
                            </button>

                            <button type="button" class="btn-time-preset" data-preset="all" style="background:#ffffff;border:1px solid #cbd5e1;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                                <i class="fa-solid fa-check-double"></i> Full Day (08:00 - 17:00)
                            </button>

                            <button type="button" class="btn-time-preset" data-preset="clear" style="background:#ffffff;border:1px solid #fecaca;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#dc2626;cursor:pointer;margin-left:auto;">
                                <i class="fa-solid fa-xmark"></i> Clear All
                            </button>
                        </div>

                        <!-- All Slots -->
                        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:10px;">
                            @php
                                $allSlots = [
                                    '08:00' => '08:00 AM',
                                    '08:30' => '08:30 AM',
                                    '09:00' => '09:00 AM',
                                    '09:30' => '09:30 AM',
                                    '10:00' => '10:00 AM',
                                    '10:30' => '10:30 AM',
                                    '11:00' => '11:00 AM',
                                    '11:30' => '11:30 AM',
                                    '12:00' => '12:00 PM',
                                    '12:30' => '12:30 PM',
                                    '13:00' => '01:00 PM',
                                    '13:30' => '01:30 PM',
                                    '14:00' => '02:00 PM',
                                    '14:30' => '02:30 PM',
                                    '15:00' => '03:00 PM',
                                    '15:30' => '03:30 PM',
                                    '16:00' => '04:00 PM',
                                    '16:30' => '04:30 PM',
                                    '17:00' => '05:00 PM',
                                    '17:30' => '05:30 PM',
                                    '18:00' => '06:00 PM',
                                    '18:30' => '06:30 PM',
                                    '19:00' => '07:00 PM',
                                ];

                                $startH = (int)date('H', strtotime($schedule->start_time));
                                $startM = (int)date('i', strtotime($schedule->start_time));
                                $endH = (int)date('H', strtotime($schedule->end_time));
                                $endM = (int)date('i', strtotime($schedule->end_time));
                                $schedStartMin = $startH * 60 + $startM;
                                $schedEndMin = $endH * 60 + $endM;
                            @endphp

                            @foreach($allSlots as $val => $label)
                                @php
                                    $parts = explode(':', $val);
                                    $slotMin = (int)$parts[0] * 60 + (int)$parts[1];
                                    $isSelected = ($slotMin >= $schedStartMin && $slotMin < $schedEndMin);
                                @endphp
                                <label class="time-slot-pill" style="cursor:pointer;user-select:none;">
                                    <input type="checkbox" name="available_hours[]" value="{{ $val }}" style="display:none;" class="slot-checkbox" {{ $isSelected ? 'checked' : '' }}>
                                    <div class="slot-box" style="padding:10px 12px;border:1.5px solid #cbd5e1;border-radius:8px;background:#ffffff;text-align:center;font-size:13px;font-weight:600;color:#334155;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <i class="fa-regular fa-clock" style="font-size:12px;color:#64748b;"></i>
                                        <span>{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div style="margin-top:36px;border-top:1.5px solid #e2e8f0;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                        
                        <div style="display:flex;align-items:center;gap:12px;">
                            <button
                                type="submit"
                                id="submitBtn"
                                class="btn btn-primary"
                                style="background:#095eff;color:#ffffff;border:none;padding:14px 32px;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;display:inline-flex;align-items:center;gap:10px;box-shadow:0 3px 12px rgba(9,94,255,0.3);transition:all 0.2s;"
                            >
                                <i class="fa-solid fa-check"></i> Update Schedule
                            </button>

                            <a
                                href="{{ route('admin.appointments.index') }}"
                                style="background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:14px 24px;border-radius:8px;font-weight:600;font-size:15px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;"
                            >
                                Cancel
                            </a>
                        </div>

                        <span style="font-size:13px;color:#64748b;">
                            <i class="fa-solid fa-circle-info" style="color:#095eff;"></i> Fields marked with <span style="color:#ef4444;">*</span> are required
                        </span>

                    </div>

                </form>

            </div>

</section>

<style>
.time-slot-pill .slot-box:hover {
    border-color: #095eff !important;
    background: #f0f7ff !important;
}

.time-slot-pill input:checked + .slot-box {
    background: #095eff !important;
    border-color: #095eff !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(9, 94, 255, 0.35);
}

.time-slot-pill input:checked + .slot-box i {
    color: #ffffff !important;
}

#submitBtn:hover {
    background: #004ecc !important;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countBadgeText = document.getElementById('countText');
    const slotCheckboxes = document.querySelectorAll('.slot-checkbox');

    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.slot-checkbox:checked').length;
        if (checkedCount === 0) {
            countBadgeText.textContent = '0 hours selected';
            document.getElementById('selectedCountBadge').style.background = '#fef2f2';
            document.getElementById('selectedCountBadge').style.color = '#dc2626';
        } else {
            countBadgeText.textContent = checkedCount + ' hour' + (checkedCount > 1 ? 's' : '') + ' selected';
            document.getElementById('selectedCountBadge').style.background = '#dbeafe';
            document.getElementById('selectedCountBadge').style.color = '#1e40af';
        }
    }

    slotCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });

    document.querySelectorAll('.btn-time-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const preset = this.getAttribute('data-preset');

            slotCheckboxes.forEach(cb => {
                const val = cb.value;
                const hour = parseInt(val.split(':')[0], 10);

                if (preset === 'clear') {
                    cb.checked = false;
                } else if (preset === 'all') {
                    cb.checked = (hour >= 8 && hour <= 17);
                } else if (preset === 'morning') {
                    cb.checked = (hour >= 8 && hour <= 12);
                } else if (preset === 'afternoon') {
                    cb.checked = (hour >= 13 && hour <= 17);
                }
            });

            updateSelectedCount();
        });
    });

    updateSelectedCount();
});
</script>

@endsection
