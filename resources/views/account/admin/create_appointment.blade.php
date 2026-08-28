@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:14px;color:#64748b;">
        <a href="{{ route('admin.dashboard') }}" style="color:#095eff;text-decoration:none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <a href="{{ route('admin.appointments.index') }}" style="color:#095eff;text-decoration:none;">Appointments</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <span style="color:#1e293b;font-weight:600;">Create Schedule</span>
    </div>

    <!-- Page Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-title" style="margin-bottom:6px;font-size:26px;font-weight:700;color:#0f172a;">
                Create Appointment Schedule
            </h1>
            <p class="page-subtitle" style="margin:0;color:#64748b;font-size:15px;">
                Configure doctor availability across specific dates or a date interval with custom consultation hours.
            </p>
        </div>

        <a href="{{ route('admin.appointments.index') }}" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 18px;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-size:14px;transition:all 0.2s;">
            <i class="fa-solid fa-arrow-left"></i> Back to Appointments
        </a>
    </div>

    {{-- ERROR VALIDATION NOTIFICATION --}}
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

    <!-- Main Form Card -->
    <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,0.04);padding:32px;max-width:960px;margin:0 auto 40px auto;">

        <form method="POST" action="{{ route('admin.appointments.store') }}" id="appointmentCreateForm">
            @csrf

            <!-- ==========================================
                 SECTION 1: DOCTOR & PRICE SELECTION
            =========================================== -->
            <div style="margin-bottom:30px;">
                <h3 style="font-size:17px;font-weight:700;color:#1e293b;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <span style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:#095eff;color:#fff;font-size:13px;">1</span>
                    Doctor & Consultation Pricing
                </h3>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
                    
                    <!-- Doctor Dropdown -->
                    <div style="grid-column:1/-1;">
                        <label for="doctor_id" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                            Select Doctor <span style="color:#ef4444;">*</span>
                        </label>

                        <select id="doctor_id" name="doctor_id" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;transition:border-color 0.2s;">
                            <option value="">-- Choose a doctor from database --</option>
                            @foreach($doctors as $doctor)
                                <option
                                    value="{{ $doctor->id }}"
                                    data-fee="{{ $doctor->consultation_fee }}"
                                    data-specialty="{{ $doctor->specialty }}"
                                    data-name="{{ $doctor->doctor_name }}"
                                    data-exp="{{ $doctor->years_of_experience }}"
                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                >
                                    Dr. {{ $doctor->doctor_name }} ({{ $doctor->specialty }} - Exp: {{ $doctor->years_of_experience }} yrs - Standard Fee: {{ number_format($doctor->consultation_fee, 0, ',', ' ') }} XAF) [{{ ucfirst($doctor->status) }}]
                                </option>
                            @endforeach
                        </select>

                        <!-- Live Doctor Info Preview -->
                        <div id="doctorPreviewCard" style="display:none;margin-top:12px;padding:12px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;display:flex;align-items:center;gap:12px;">
                            <div style="width:42px;height:42px;border-radius:50%;background:#e0e7ff;color:#4338ca;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div>
                                <strong id="previewDocName" style="color:#0f172a;font-size:15px;display:block;"></strong>
                                <span id="previewDocSpecialty" style="font-size:13px;color:#64748b;"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Price -->
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
                                placeholder="e.g. 5000"
                                value="{{ old('price') }}"
                                required
                                style="width:100%;padding:12px 60px 12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                            >
                            <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748b;font-weight:700;font-size:14px;pointer-events:none;">
                                XAF
                            </span>
                        </div>
                        <small style="display:block;margin-top:6px;color:#64748b;font-size:12px;">
                            Automatically populated with doctor's base rate, can be customized.
                        </small>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                            Availability Status <span style="color:#ef4444;">*</span>
                        </label>

                        <select id="status" name="status" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available (Open for booking)</option>
                            <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable (Temporarily closed)</option>
                        </select>
                    </div>

                    <!-- Reason / Type -->
                    <div style="grid-column:1/-1;">
                        <label for="reason" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                            Consultation Type / Note (Optional)
                        </label>

                        <input
                            type="text"
                            id="reason"
                            name="reason"
                            placeholder="e.g. General Consultation, Follow-up Review, In-Person Visit"
                            value="{{ old('reason', 'General Consultation') }}"
                            style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                        >
                    </div>

                </div>
            </div>

            <hr style="border:none;border-top:1px solid #e2e8f0;margin:30px 0;">

            <!-- ==========================================
                 SECTION 2: DATE INTERVAL & SCHEDULING MODE
            =========================================== -->
            <div style="margin-bottom:30px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
                    <div>
                        <h3 style="font-size:17px;font-weight:700;color:#1e293b;margin:0 0 4px 0;display:flex;align-items:center;gap:8px;">
                            <span style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:#095eff;color:#fff;font-size:13px;">2</span>
                            Date Interval & Schedule Period <span style="color:#ef4444;">*</span>
                        </h3>
                        <p style="margin:0;font-size:13px;color:#64748b;">
                            Specify a date interval (plage de dates) to generate multiple schedules at once, or choose a single date.
                        </p>
                    </div>

                    <span id="dateCountBadge" style="background:#eff6ff;color:#1d4ed8;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:6px;border:1px solid #bfdbfe;">
                        <i class="fa-regular fa-calendar-days"></i> <span id="dateSummaryText">Date Range active</span>
                    </span>
                </div>

                <!-- Schedule Mode Selector (Tabs) -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
                    
                    <label class="schedule-mode-card" id="modeCardRange" style="border:2px solid #095eff;background:#f0f7ff;padding:16px;border-radius:10px;cursor:pointer;display:flex;align-items:center;gap:12px;transition:all 0.2s;">
                        <input type="radio" name="schedule_mode" value="range" id="mode_range" {{ old('schedule_mode', 'range') === 'range' ? 'checked' : '' }} style="accent-color:#095eff;width:18px;height:18px;">
                        <div>
                            <strong style="color:#0f172a;font-size:14px;display:block;">
                                <i class="fa-solid fa-calendar-week" style="color:#095eff;margin-right:4px;"></i> Date Range / Interval (Plage de dates)
                            </strong>
                            <span style="color:#64748b;font-size:12px;">Generate schedules across a range of days / weeks</span>
                        </div>
                    </label>

                    <label class="schedule-mode-card" id="modeCardSingle" style="border:1.5px solid #cbd5e1;background:#ffffff;padding:16px;border-radius:10px;cursor:pointer;display:flex;align-items:center;gap:12px;transition:all 0.2s;">
                        <input type="radio" name="schedule_mode" value="single" id="mode_single" {{ old('schedule_mode') === 'single' ? 'checked' : '' }} style="accent-color:#095eff;width:18px;height:18px;">
                        <div>
                            <strong style="color:#0f172a;font-size:14px;display:block;">
                                <i class="fa-regular fa-calendar" style="color:#64748b;margin-right:4px;"></i> Single Date (Date unique)
                            </strong>
                            <span style="color:#64748b;font-size:12px;">Create availability for a single specific day</span>
                        </div>
                    </label>

                </div>

                <!-- DATE RANGE CONTAINER -->
                <div id="dateRangeContainer" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px;">
                    
                    <!-- Quick Range Presets -->
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;align-items:center;">
                        <span style="font-size:12px;font-weight:600;color:#64748b;">Quick Date Presets:</span>
                        
                        <button type="button" class="btn-range-preset" data-days="7" style="background:#ffffff;border:1px solid #cbd5e1;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                            Next 7 Days
                        </button>
                        <button type="button" class="btn-range-preset" data-days="14" style="background:#ffffff;border:1px solid #cbd5e1;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                            Next 14 Days (2 Weeks)
                        </button>
                        <button type="button" class="btn-range-preset" data-days="30" style="background:#ffffff;border:1px solid #cbd5e1;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                            Next 30 Days (1 Month)
                        </button>
                        <button type="button" class="btn-range-preset" data-days="current-month" style="background:#ffffff;border:1px solid #cbd5e1;padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                            Rest of This Month
                        </button>
                    </div>

                    <!-- Start & End Date Inputs -->
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:20px;">
                        
                        <div>
                            <label for="start_date" style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">
                                <i class="fa-regular fa-calendar-plus" style="color:#095eff;"></i> Start Date (Date de début) <span style="color:#ef4444;">*</span>
                            </label>
                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                style="width:100%;padding:10px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;background:#ffffff;"
                            >
                        </div>

                        <div>
                            <label for="end_date" style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">
                                <i class="fa-regular fa-calendar-check" style="color:#059669;"></i> End Date (Date de fin) <span style="color:#ef4444;">*</span>
                            </label>
                            <input
                                type="date"
                                id="end_date"
                                name="end_date"
                                value="{{ old('end_date', date('Y-m-d', strtotime('+14 days'))) }}"
                                min="{{ date('Y-m-d') }}"
                                style="width:100%;padding:10px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;background:#ffffff;"
                            >
                        </div>

                    </div>

                    <!-- Days of the week filter -->
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                            <label style="font-weight:600;font-size:13px;color:#1e293b;margin:0;">
                                <i class="fa-solid fa-repeat" style="color:#095eff;"></i> Repeat on Days (Jours de la semaine) :
                            </label>

                            <div style="display:flex;gap:6px;">
                                <button type="button" class="btn-day-preset" data-days="all" style="background:#ffffff;border:1px solid #cbd5e1;padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;color:#0f172a;cursor:pointer;">
                                    All Days
                                </button>
                                <button type="button" class="btn-day-preset" data-days="weekdays" style="background:#ffffff;border:1px solid #cbd5e1;padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;color:#0f172a;cursor:pointer;">
                                    Mon - Fri (Weekdays)
                                </button>
                                <button type="button" class="btn-day-preset" data-days="weekends" style="background:#ffffff;border:1px solid #cbd5e1;padding:4px 10px;border-radius:6px;font-size:11px;font-weight:600;color:#0f172a;cursor:pointer;">
                                    Sat - Sun (Weekends)
                                </button>
                            </div>
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(110px, 1fr));gap:8px;">
                            @php
                                $daysMap = [
                                    'Monday'    => ['label' => 'Monday', 'short' => 'Mon'],
                                    'Tuesday'   => ['label' => 'Tuesday', 'short' => 'Tue'],
                                    'Wednesday' => ['label' => 'Wednesday', 'short' => 'Wed'],
                                    'Thursday'  => ['label' => 'Thursday', 'short' => 'Thu'],
                                    'Friday'    => ['label' => 'Friday', 'short' => 'Fri'],
                                    'Saturday'  => ['label' => 'Saturday', 'short' => 'Sat'],
                                    'Sunday'    => ['label' => 'Sunday', 'short' => 'Sun'],
                                ];
                                $selectedDays = old('days_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
                            @endphp

                            @foreach($daysMap as $dayVal => $dayMeta)
                                <label class="day-checkbox-pill" style="cursor:pointer;user-select:none;">
                                    <input
                                        type="checkbox"
                                        name="days_of_week[]"
                                        value="{{ $dayVal }}"
                                        style="display:none;"
                                        class="day-checkbox"
                                        data-day="{{ strtolower($dayVal) }}"
                                        {{ in_array($dayVal, $selectedDays) ? 'checked' : '' }}
                                    >
                                    <div class="day-box" style="padding:8px 10px;border:1.5px solid #cbd5e1;border-radius:8px;background:#ffffff;text-align:center;font-size:12px;font-weight:600;color:#334155;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <span>{{ $dayMeta['label'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- SINGLE DATE CONTAINER (Hidden by default unless Single mode is active) -->
                <div id="singleDateContainer" style="display:none;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px;">
                    
                    <div style="max-width:320px;">
                        <label for="single_date" style="display:block;font-weight:600;font-size:13px;color:#1e293b;margin-bottom:6px;">
                            <i class="fa-regular fa-calendar" style="color:#095eff;"></i> Consultation Date (Date de consultation) <span style="color:#ef4444;">*</span>
                        </label>
                        <input
                            type="date"
                            id="single_date"
                            name="date"
                            value="{{ old('date', date('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}"
                            style="width:100%;padding:10px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;background:#ffffff;"
                        >
                    </div>

                </div>

            </div>

            <hr style="border:none;border-top:1px solid #e2e8f0;margin:30px 0;">

            <!-- ==========================================
                 SECTION 3: DOCTOR AVAILABLE HOURS SELECTION
            =========================================== -->
            <div style="margin-bottom:30px;">
                
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
                    <div>
                        <h3 style="font-size:17px;font-weight:700;color:#1e293b;margin:0 0 4px 0;display:flex;align-items:center;gap:8px;">
                            <span style="display:flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:#095eff;color:#fff;font-size:13px;">3</span>
                            Select Doctor's Available Consultation Hours <span style="color:#ef4444;">*</span>
                        </h3>
                        <p style="margin:0;font-size:13px;color:#64748b;">
                            Select the available consultation time slots for the doctor. Patients can book appointments within this range.
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
                        <i class="fa-regular fa-sun"></i> Morning (08:00 - 12:30)
                    </button>

                    <button type="button" class="btn-time-preset" data-preset="afternoon" style="background:#ffffff;border:1px solid #cbd5e1;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                        <i class="fa-regular fa-cloud-sun"></i> Afternoon (13:00 - 17:30)
                    </button>

                    <button type="button" class="btn-time-preset" data-preset="all" style="background:#ffffff;border:1px solid #cbd5e1;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#0369a1;cursor:pointer;">
                        <i class="fa-solid fa-check-double"></i> Full Day (08:00 - 17:30)
                    </button>

                    <button type="button" class="btn-time-preset" data-preset="clear" style="background:#ffffff;border:1px solid #fecaca;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:600;color:#dc2626;cursor:pointer;margin-left:auto;">
                        <i class="fa-solid fa-xmark"></i> Clear All
                    </button>
                </div>

                <!-- Time Slots Grid Container -->
                <div style="display:flex;flex-direction:column;gap:20px;">
                    
                    <!-- MORNING SLOTS -->
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#0369a1;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                            <i class="fa-regular fa-sun" style="color:#f59e0b;"></i> Morning Slots (08:00 AM - 12:30 PM)
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:10px;">
                            @php
                                $morningSlots = [
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
                                ];
                            @endphp

                            @foreach($morningSlots as $val => $label)
                                <label class="time-slot-pill" data-period="morning" style="cursor:pointer;user-select:none;">
                                    <input type="checkbox" name="available_hours[]" value="{{ $val }}" style="display:none;" class="slot-checkbox">
                                    <div class="slot-box" style="padding:10px 12px;border:1.5px solid #cbd5e1;border-radius:8px;background:#ffffff;text-align:center;font-size:13px;font-weight:600;color:#334155;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <i class="fa-regular fa-clock" style="font-size:12px;color:#64748b;"></i>
                                        <span>{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- AFTERNOON SLOTS -->
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#0369a1;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                            <i class="fa-regular fa-cloud-sun" style="color:#0284c7;"></i> Afternoon Slots (01:00 PM - 05:30 PM)
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:10px;">
                            @php
                                $afternoonSlots = [
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
                                ];
                            @endphp

                            @foreach($afternoonSlots as $val => $label)
                                <label class="time-slot-pill" data-period="afternoon" style="cursor:pointer;user-select:none;">
                                    <input type="checkbox" name="available_hours[]" value="{{ $val }}" style="display:none;" class="slot-checkbox">
                                    <div class="slot-box" style="padding:10px 12px;border:1.5px solid #cbd5e1;border-radius:8px;background:#ffffff;text-align:center;font-size:13px;font-weight:600;color:#334155;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <i class="fa-regular fa-clock" style="font-size:12px;color:#64748b;"></i>
                                        <span>{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- EVENING SLOTS -->
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#0369a1;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                            <i class="fa-regular fa-moon" style="color:#6366f1;"></i> Evening Slots (06:00 PM - 08:00 PM)
                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:10px;">
                            @php
                                $eveningSlots = [
                                    '18:00' => '06:00 PM',
                                    '18:30' => '06:30 PM',
                                    '19:00' => '07:00 PM',
                                    '19:30' => '07:30 PM',
                                    '20:00' => '08:00 PM',
                                ];
                            @endphp

                            @foreach($eveningSlots as $val => $label)
                                <label class="time-slot-pill" data-period="evening" style="cursor:pointer;user-select:none;">
                                    <input type="checkbox" name="available_hours[]" value="{{ $val }}" style="display:none;" class="slot-checkbox">
                                    <div class="slot-box" style="padding:10px 12px;border:1.5px solid #cbd5e1;border-radius:8px;background:#ffffff;text-align:center;font-size:13px;font-weight:600;color:#334155;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <i class="fa-regular fa-clock" style="font-size:12px;color:#64748b;"></i>
                                        <span>{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

            <!-- ==========================================
                 SECTION 4: VALIDATION & FORM ACTIONS
            =========================================== -->
            <div style="margin-top:36px;border-top:1.5px solid #e2e8f0;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                
                <div style="display:flex;align-items:center;gap:12px;">
                    <button
                        type="submit"
                        id="submitBtn"
                        class="btn btn-primary"
                        style="background:#095eff;color:#ffffff;border:none;padding:14px 32px;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;display:inline-flex;align-items:center;gap:10px;box-shadow:0 3px 12px rgba(9,94,255,0.3);transition:all 0.2s;"
                    >
                        <i class="fa-solid fa-check"></i> Generate Doctor Schedule
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

<!-- Styles & JavaScript for interactive selection -->
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

.day-checkbox-pill .day-box:hover {
    border-color: #095eff !important;
    background: #f0f7ff !important;
}

.day-checkbox-pill input:checked + .day-box {
    background: #095eff !important;
    border-color: #095eff !important;
    color: #ffffff !important;
}

#submitBtn:hover {
    background: #004ecc !important;
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor_id');
    const priceInput = document.getElementById('price');
    const doctorPreview = document.getElementById('doctorPreviewCard');
    const previewDocName = document.getElementById('previewDocName');
    const previewDocSpecialty = document.getElementById('previewDocSpecialty');
    const countBadgeText = document.getElementById('countText');
    const slotCheckboxes = document.querySelectorAll('.slot-checkbox');
    
    // Mode toggles
    const modeRangeRadio = document.getElementById('mode_range');
    const modeSingleRadio = document.getElementById('mode_single');
    const modeCardRange = document.getElementById('modeCardRange');
    const modeCardSingle = document.getElementById('modeCardSingle');
    const dateRangeContainer = document.getElementById('dateRangeContainer');
    const singleDateContainer = document.getElementById('singleDateContainer');
    const dateSummaryText = document.getElementById('dateSummaryText');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const singleDateInput = document.getElementById('single_date');
    const dayCheckboxes = document.querySelectorAll('.day-checkbox');

    // 1. Doctor selection auto-fill fee & show preview
    function updateDoctorInfo() {
        const selected = doctorSelect.options[doctorSelect.selectedIndex];
        if (selected && selected.value) {
            const fee = selected.getAttribute('data-fee');
            const specialty = selected.getAttribute('data-specialty');
            const name = selected.getAttribute('data-name');
            const exp = selected.getAttribute('data-exp');

            if (fee && (!priceInput.value || priceInput.getAttribute('data-autofilled') === 'true')) {
                priceInput.value = parseFloat(fee);
                priceInput.setAttribute('data-autofilled', 'true');
            }

            if (name) {
                previewDocName.textContent = 'Dr. ' + name;
                previewDocSpecialty.textContent = (specialty || 'Specialist') + ' • ' + (exp ? exp + ' years experience' : '');
                doctorPreview.style.display = 'flex';
            }
        } else {
            doctorPreview.style.display = 'none';
        }
    }

    doctorSelect.addEventListener('change', updateDoctorInfo);
    priceInput.addEventListener('input', function() {
        priceInput.setAttribute('data-autofilled', 'false');
    });

    if (doctorSelect.value) {
        updateDoctorInfo();
    }

    // 2. Mode Switching (Range vs Single)
    function updateModeDisplay() {
        if (modeRangeRadio.checked) {
            dateRangeContainer.style.display = 'block';
            singleDateContainer.style.display = 'none';
            modeCardRange.style.borderColor = '#095eff';
            modeCardRange.style.background = '#f0f7ff';
            modeCardSingle.style.borderColor = '#cbd5e1';
            modeCardSingle.style.background = '#ffffff';
            dateSummaryText.textContent = 'Date Interval Mode';
        } else {
            dateRangeContainer.style.display = 'none';
            singleDateContainer.style.display = 'block';
            modeCardSingle.style.borderColor = '#095eff';
            modeCardSingle.style.background = '#f0f7ff';
            modeCardRange.style.borderColor = '#cbd5e1';
            modeCardRange.style.background = '#ffffff';
            dateSummaryText.textContent = 'Single Date Mode';
        }
    }

    modeRangeRadio.addEventListener('change', updateModeDisplay);
    modeSingleRadio.addEventListener('change', updateModeDisplay);
    updateModeDisplay();

    // 3. Quick Date Range Presets
    document.querySelectorAll('.btn-range-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const today = new Date();
            const formatD = (d) => d.toISOString().split('T')[0];
            
            const days = this.getAttribute('data-days');
            startDateInput.value = formatD(today);

            if (days === 'current-month') {
                const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                endDateInput.value = formatD(lastDay);
            } else {
                const target = new Date();
                target.setDate(today.getDate() + parseInt(days, 10));
                endDateInput.value = formatD(target);
            }
        });
    });

    // 4. Quick Day Presets (All / Weekdays / Weekends)
    document.querySelectorAll('.btn-day-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-days');
            dayCheckboxes.forEach(cb => {
                const day = cb.getAttribute('data-day');
                if (type === 'all') {
                    cb.checked = true;
                } else if (type === 'weekdays') {
                    cb.checked = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'].includes(day);
                } else if (type === 'weekends') {
                    cb.checked = ['saturday', 'sunday'].includes(day);
                }
            });
        });
    });

    // 5. Update count of selected slots
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

    // 6. Time Preset Buttons handler
    document.querySelectorAll('.btn-time-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const preset = this.getAttribute('data-preset');

            slotCheckboxes.forEach(cb => {
                const label = cb.closest('.time-slot-pill');
                const period = label.getAttribute('data-period');
                const val = cb.value;

                if (preset === 'clear') {
                    cb.checked = false;
                } else if (preset === 'all') {
                    // 08:00 to 17:30
                    const hour = parseInt(val.split(':')[0], 10);
                    cb.checked = (hour >= 8 && hour <= 17);
                } else if (preset === 'morning') {
                    cb.checked = (period === 'morning');
                } else if (preset === 'afternoon') {
                    cb.checked = (period === 'afternoon');
                }
            });

            updateSelectedCount();
        });
    });

    // 7. Form validation check before submit
    document.getElementById('appointmentCreateForm').addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.slot-checkbox:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            alert('Please select at least one available hour/slot for the doctor.');
            document.getElementById('selectedCountBadge').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        if (modeRangeRadio.checked) {
            if (!startDateInput.value || !endDateInput.value) {
                e.preventDefault();
                alert('Please specify both Start Date and End Date for the interval.');
                startDateInput.focus();
                return;
            }
            if (new Date(endDateInput.value) < new Date(startDateInput.value)) {
                e.preventDefault();
                alert('End Date must be on or after Start Date.');
                endDateInput.focus();
                return;
            }
        } else {
            if (!singleDateInput.value) {
                e.preventDefault();
                alert('Please select a consultation date.');
                singleDateInput.focus();
                return;
            }
        }
    });

    // Default select standard morning/afternoon slots if none selected
    const initialChecked = document.querySelectorAll('.slot-checkbox:checked').length;
    if (initialChecked === 0) {
        slotCheckboxes.forEach(cb => {
            const val = cb.value;
            const hour = parseInt(val.split(':')[0], 10);
            if (hour >= 8 && hour <= 16 && (val.endsWith(':00') || val.endsWith(':30'))) {
                cb.checked = true;
            }
        });
    }

    updateSelectedCount();
});
</script>

@endsection
