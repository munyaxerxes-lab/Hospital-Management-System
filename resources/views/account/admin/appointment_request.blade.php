@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <h1 class="page-title">Manage Appointment Schedules</h1>

    <p class="page-subtitle">
        Create doctor appointment slots, set booking hours & consultation pricing, and manage patient availability.
    </p>

    {{-- =========================
         SUCCESS NOTIFICATION
    ========================== --}}
    @if (session('success'))
        <div class="alert alert-success" id="success-message" style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:10px;background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;margin-bottom:20px;font-weight:500;">
            <i class="fa-solid fa-circle-check" style="color:#059669;font-size:18px;"></i>
            <span>{{ session('success') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const message = document.getElementById('success-message');
                if (message) {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(function () {
                        message.remove();
                    }, 500);
                }
            }, 3500);
        </script>
    @endif

    {{-- =========================
         STATISTICS CARDS
    ========================== --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
        
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:22px;">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Total Schedules</span>
                <strong style="font-size:22px;color:#1e293b;font-weight:700;">{{ $stats['total'] ?? 0 }}</strong>
            </div>
        </div>

        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:22px;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Available Slots</span>
                <strong style="font-size:22px;color:#059669;font-weight:700;">{{ $stats['available'] ?? 0 }}</strong>
            </div>
        </div>

        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#fef2f2;color:#dc2626;display:flex;align-items:center;justify-content:center;font-size:22px;">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Unavailable / Closed</span>
                <strong style="font-size:22px;color:#dc2626;font-weight:700;">{{ $stats['unavailable'] ?? 0 }}</strong>
            </div>
        </div>

        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#faf5ff;color:#7e22ce;display:flex;align-items:center;justify-content:center;font-size:22px;">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Active Doctors</span>
                <strong style="font-size:22px;color:#7e22ce;font-weight:700;">{{ $stats['doctors_count'] ?? 0 }}</strong>
            </div>
        </div>

    </div>

    {{-- =========================
         TOP ACTION BAR & CREATE BUTTONS
    ========================== --}}
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
        
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <!-- Redirect to Create Page -->
            <a href="{{ route('admin.appointments.create') }}" class="open-btn" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-plus"></i> Create Appointment
            </a>

            <!-- Quick Modal Trigger -->
            <button type="button" popovertarget="quick-create-modal" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:12px 18px;border-radius:8px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-bolt"></i> Quick Modal
            </button>

            <!-- Manage Doctors Shortcut Button -->
            <a href="{{ route('admin.doctors.index') }}" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;padding:12px 18px;border-radius:8px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-user-doctor"></i> Manage Doctors
            </a>
        </div>

                <!-- Search & Filters -->
                <form method="GET" action="{{ route('admin.appointments.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    
                    <div style="position:relative;">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search doctor, reason..."
                            style="padding:10px 14px 10px 36px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;width:220px;"
                        >
                        <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                    </div>

                    <select name="status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                        <option value="all">All Statuses</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        <option value="booked" {{ request('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>

                    <select name="doctor_id" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                        <option value="all">All Doctors</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                                Dr. {{ $doc->doctor_name }}
                            </option>
                        @endforeach
                    </select>

                    @if(request()->hasAny(['search', 'status', 'doctor_id']) && (request('search') || request('status') !== 'all' || request('doctor_id') !== 'all'))
                        <a href="{{ route('admin.appointments.index') }}" style="color:#ef4444;font-size:13px;text-decoration:none;font-weight:600;padding:8px 10px;">
                            <i class="fa-solid fa-xmark"></i> Clear
                        </a>
                    @endif

                </form>

            </div>

            <!-- =====================================================
                 QUICK CREATE APPOINTMENT MODAL (POPOVER)
            ====================================================== -->
            <div id="quick-create-modal" popover class="modal-box">

                <div class="modal-content" style="max-width:680px;">

                    <form method="POST" action="{{ route('admin.appointments.store') }}" class="doctor-form">
                        @csrf

                        <div class="form-title">
                            Quick Create Appointment Schedule
                        </div>

                        <div class="form-grid">

                            <!-- Doctor -->
                            <div class="field full">
                                <label for="modal_doctor_id">Select Doctor *</label>
                                <select id="modal_doctor_id" name="doctor_id" required onchange="updateModalFee(this)">
                                    <option value="">-- Choose Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" data-fee="{{ $doctor->consultation_fee }}">
                                            Dr. {{ $doctor->doctor_name }} ({{ $doctor->specialty }} - Standard: {{ number_format($doctor->consultation_fee, 0, ',', ' ') }} XAF)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price -->
                            <div class="field">
                                <label for="modal_price">Price (XAF) *</label>
                                <input type="number" id="modal_price" name="price" min="0" step="100" placeholder="e.g. 5000" required>
                            </div>

                            <!-- Status -->
                            <div class="field">
                                <label for="modal_status">Status *</label>
                                <select id="modal_status" name="status" required>
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </div>

                            <!-- Reason -->
                            <div class="field full">
                                <label for="modal_reason">Consultation Type / Note</label>
                                <input type="text" id="modal_reason" name="reason" value="General Consultation" placeholder="e.g. Follow-up">
                            </div>

                            <!-- Doctor Available Hours Selection -->
                            <div class="field full">
                                <label style="display:block;margin-bottom:6px;font-weight:600;">
                                    Select Available Consultation Hours *
                                </label>
                                
                                <div style="display:flex;gap:6px;flex-wrap:wrap;max-height:160px;overflow-y:auto;padding:8px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;">
                                    @php
                                        $modalSlots = [
                                            '08:00' => '08:00 AM',
                                            '08:30' => '08:30 AM',
                                            '09:00' => '09:00 AM',
                                            '09:30' => '09:30 AM',
                                            '10:00' => '10:00 AM',
                                            '10:30' => '10:30 AM',
                                            '11:00' => '11:00 AM',
                                            '11:30' => '11:30 AM',
                                            '12:00' => '12:00 PM',
                                            '13:00' => '01:00 PM',
                                            '13:30' => '01:30 PM',
                                            '14:00' => '02:00 PM',
                                            '14:30' => '02:30 PM',
                                            '15:00' => '03:00 PM',
                                            '15:30' => '03:30 PM',
                                            '16:00' => '04:00 PM',
                                            '16:30' => '04:30 PM',
                                            '17:00' => '05:00 PM',
                                        ];
                                    @endphp

                                    @foreach($modalSlots as $val => $label)
                                        <label style="cursor:pointer;">
                                            <input type="checkbox" name="available_hours[]" value="{{ $val }}" checked style="display:none;" class="modal-slot-cb">
                                            <span class="modal-slot-pill" style="padding:6px 10px;background:#095eff;color:#fff;border-radius:6px;font-size:12px;font-weight:600;display:inline-block;border:1px solid #095eff;transition:all 0.2s;">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="save-row">
                            <button type="submit" class="btn btn-primary save-btn">
                                <i class="fa-solid fa-check"></i> Save Appointment Schedule
                            </button>
                        </div>

                    </form>

                    <button popovertarget="quick-create-modal" popovertargetaction="hide" class="close-btn">
                        Close
                    </button>

                </div>

            </div>

            <!-- =====================================================
                 APPOINTMENTS DATA TABLE
            ====================================================== -->
            <div class="doctors-layout">

                <div>

                    <table class="data-table">

                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Doctor</th>
                                <th>Specialty</th>
                                <th>Date</th>
                                <th>Available Hours</th>
                                <th>Fee (XAF)</th>
                                <th>Status</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($schedules as $schedule)

                                <tr>
                                    <td>
                                        <span style="font-weight:600;color:#64748b;">
                                            {{ $loop->iteration + ($schedules->currentPage() - 1) * $schedules->perPage() }}
                                        </span>
                                    </td>

                                    <!-- Doctor Info -->
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div style="width:36px;height:36px;border-radius:50%;background:#e0e7ff;color:#4338ca;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;">
                                                <i class="fa-solid fa-user-doctor"></i>
                                            </div>
                                            <div>
                                                <strong style="color:#0f172a;display:block;">
                                                    Dr. {{ $schedule->doctor->doctor_name ?? 'Unassigned Doctor' }}
                                                </strong>
                                                <small style="color:#64748b;font-size:12px;">
                                                    {{ $schedule->reason ?? 'General Consultation' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Specialty -->
                                    <td>
                                        <span style="background:#f1f5f9;color:#334155;padding:4px 10px;border-radius:6px;font-size:13px;font-weight:500;">
                                            {{ $schedule->doctor->specialty ?? 'General' }}
                                        </span>
                                    </td>

                                    <!-- Date -->
                                    <td>
                                        <div style="font-weight:600;color:#1e293b;">
                                            <i class="fa-regular fa-calendar" style="color:#095eff;margin-right:4px;"></i>
                                            {{ is_string($schedule->date) ? date('D, M d, Y', strtotime($schedule->date)) : $schedule->date?->format('D, M d, Y') }}
                                        </div>
                                    </td>

                                    <!-- Horaires / Available Hours -->
                                    <td>
                                        <div style="display:inline-flex;align-items:center;gap:6px;background:#f8fafc;border:1px solid #e2e8f0;padding:4px 10px;border-radius:6px;font-weight:600;font-size:13px;color:#0f172a;">
                                            <i class="fa-regular fa-clock" style="color:#095eff;"></i>
                                            {{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }}
                                        </div>
                                    </td>

                                    <!-- Fee -->
                                    <td>
                                        <strong style="color:#059669;font-size:14px;">
                                            {{ number_format($schedule->price ?? $schedule->doctor?->consultation_fee ?? 0, 0, ',', ' ') }} XAF
                                        </strong>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($schedule->status === 'available' || $schedule->status === 'active')
                                            <span class="badge green" style="background:#ecfdf5;color:#059669;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                                                <i class="fa-solid fa-circle" style="font-size:6px;"></i> Available
                                            </span>
                                        @elseif($schedule->status === 'booked')
                                            <span class="badge" style="background:#eff6ff;color:#2563eb;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                                                <i class="fa-solid fa-circle" style="font-size:6px;"></i> Booked
                                            </span>
                                        @else
                                            <span class="badge red" style="background:#fef2f2;color:#dc2626;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                                                <i class="fa-solid fa-circle" style="font-size:6px;"></i> Unavailable
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="actions-cell" style="text-align:center;">
                                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                            <!-- Toggle Status -->
                                            <form method="POST" action="{{ route('admin.appointments.toggleStatus', $schedule->id) }}" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="icon-btn"
                                                    style="background:#f1f5f9;color:#475569;border:none;width:34px;height:34px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;"
                                                    title="{{ ($schedule->status === 'available' || $schedule->status === 'active') ? 'Deactivate / Mark Unavailable' : 'Activate / Mark Available' }}"
                                                >
                                                    @if($schedule->status === 'available' || $schedule->status === 'active')
                                                        <i class="fa-solid fa-pause" style="color:#d97706;"></i>
                                                    @else
                                                        <i class="fa-solid fa-play" style="color:#059669;"></i>
                                                    @endif
                                                </button>
                                            </form>

                                            <!-- Edit (Direct Link to Edit Page) -->
                                            <a
                                                href="{{ route('admin.appointments.edit', $schedule->id) }}"
                                                class="icon-btn orange"
                                                style="background:#fffbeb;color:#d97706;border:none;width:34px;height:34px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;"
                                                title="Edit Appointment Schedule"
                                            >
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <!-- Delete Trigger -->
                                            <button
                                                type="button"
                                                class="icon-btn red"
                                                popovertarget="delete-schedule-{{ $schedule->id }}"
                                                style="background:#fef2f2;color:#dc2626;border:none;width:34px;height:34px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;"
                                                title="Delete Appointment"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </div>

                                        <!-- Delete Schedule Confirmation Modal -->
                                        <div id="delete-schedule-{{ $schedule->id }}" popover class="alert-modal-box">
                                            <div class="alert-modal-content">
                                                <div class="alert-modal-icon">
                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                </div>
                                                <h3 class="alert-modal-title">Delete Appointment Schedule</h3>
                                                <p class="alert-modal-desc">
                                                    Are you sure you want to delete this schedule for <strong>Dr. {{ $schedule->doctor->doctor_name ?? 'Doctor' }}</strong> on <strong>{{ is_string($schedule->date) ? date('M d, Y', strtotime($schedule->date)) : $schedule->date?->format('M d, Y') }}</strong> ({{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }})?
                                                </p>
                                                <div class="alert-modal-box-warning">
                                                    <strong>Note:</strong> Patients will no longer be able to book this time slot.
                                                </div>
                                                <div class="alert-modal-actions">
                                                    <button type="button" popovertarget="delete-schedule-{{ $schedule->id }}" popovertargetaction="hide" class="btn-modal-cancel">
                                                        Cancel
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.appointments.delete', $schedule->id) }}" style="margin:0;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-modal-danger">
                                                            <i class="fa-solid fa-trash"></i> Yes, Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" style="text-align:center;padding:48px 20px;">
                                        <div style="max-width:360px;margin:0 auto;">
                                            <div style="width:64px;height:64px;border-radius:50%;background:#f1f5f9;color:#94a3b8;display:inline-flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:16px;">
                                                <i class="fa-regular fa-calendar-xmark"></i>
                                            </div>
                                            <h3 style="font-size:18px;color:#1e293b;margin-bottom:6px;font-weight:700;">No appointments created yet</h3>
                                            <p style="font-size:14px;color:#64748b;margin-bottom:18px;">
                                                Start by scheduling doctor availability slots so clients can book appointments.
                                            </p>
                                            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary" style="background:#095eff;color:#fff;padding:10px 22px;border-radius:8px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                                                <i class="fa-solid fa-plus"></i> Create First Appointment
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                    <!-- Pagination -->
                    @if ($schedules->hasPages())
                        <div style="margin-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                            <span style="color:#64748b;font-size:14px;">
                                Showing {{ $schedules->firstItem() ?? 0 }} to {{ $schedules->lastItem() ?? 0 }} of {{ $schedules->total() }} appointments
                            </span>
                            <div>
                                {{ $schedules->links() }}
                            </div>
                        </div>
                    @endif

                    <!-- Action Guide -->
                    <div class="action-guide" style="margin-top:32px;">
                        <div class="guide-title">
                            Appointment Management Guide
                        </div>

                        <div class="guide-grid">
                            <div class="guide-item">
                                <div class="guide-icon blue">
                                    <i class="fa-solid fa-pen"></i>
                                </div>
                                <div>
                                    <strong>Edit Schedule</strong>
                                    <span>Change doctor, adjust price or modify available hours</span>
                                </div>
                            </div>

                            <div class="guide-item">
                                <div class="guide-icon red">
                                    <i class="fa-solid fa-pause"></i>
                                </div>
                                <div>
                                    <strong>Toggle Status</strong>
                                    <span>Quickly open or close booking availability for this slot</span>
                                </div>
                            </div>

                            <div class="guide-item">
                                <div class="guide-icon red">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                                <div>
                                    <strong>Delete Schedule</strong>
                                    <span>Permanently remove the appointment schedule</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

</section>

<script>
function updateModalFee(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const fee = selectedOption.getAttribute('data-fee');
    const priceInput = document.getElementById('modal_price');
    if (fee && priceInput) {
        priceInput.value = parseFloat(fee);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-slot-cb').forEach(cb => {
        cb.addEventListener('change', function() {
            const pill = this.nextElementSibling;
            if (this.checked) {
                pill.style.background = '#095eff';
                pill.style.borderColor = '#095eff';
                pill.style.color = '#ffffff';
            } else {
                pill.style.background = '#ffffff';
                pill.style.borderColor = '#cbd5e1';
                pill.style.color = '#334155';
            }
        });
    });
});
</script>

@endsection