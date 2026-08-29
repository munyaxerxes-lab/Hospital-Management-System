@extends('admin_layout.index')
@section('content')

<section class="page" style="padding-bottom: 60px;">

    <!-- Welcome Hero Banner -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); border-radius: 16px; padding: 28px 32px; color: #ffffff; margin-bottom: 28px; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: rgba(56, 189, 248, 0.2); color: #38bdf8; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 99px; letter-spacing: 0.5px; border: 1px solid rgba(56, 189, 248, 0.3);">
                    <i class="fa-solid fa-hospital"></i> HOSPITAL OVERVIEW
                </span>
                <span style="color: #94a3b8; font-size: 13px;">
                    <i class="fa-regular fa-calendar"></i> {{ date('l, F j, Y') }}
                </span>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; margin: 0 0 6px 0; letter-spacing: -0.5px; color: #ffffff;">
                Welcome back, {{ Auth::check() ? Auth::user()->name : 'Administrator' }}
            </h1>
            <p style="margin: 0; color: #cbd5e1; font-size: 14px; max-width: 600px; line-height: 1.5;">
                Real-time operational overview of appointments, medical staff, pharmacy inventory, and diagnostic laboratories.
            </p>
        </div>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.appointments.create') }}" style="background: #2563eb; color: #ffffff; padding: 11px 20px; border-radius: 10px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); transition: all 0.2s;">
                <i class="fa-solid fa-plus"></i> New Schedule
            </a>
            <a href="{{ route('admin.doctors.index') }}" style="background: rgba(255, 255, 255, 0.12); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.2); padding: 11px 18px; border-radius: 10px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <i class="fa-solid fa-user-doctor"></i> Manage Doctors
            </a>
        </div>
    </div>

    <!-- 4 Primary KPI Stat Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 28px;">
        
        <!-- Card 1: Appointments -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #2563eb;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                        Appointments & Slots
                    </span>
                    <strong style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        {{ $stats['appointments'] ?? 0 }}
                    </strong>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
            </div>
            <div style="display: flex; gap: 12px; font-size: 12px; color: #64748b; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                <span style="display: flex; align-items: center; gap: 4px; color: #059669; font-weight: 600;">
                    <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i> {{ $stats['available_slots'] ?? 0 }} Available
                </span>
                <span style="display: flex; align-items: center; gap: 4px; color: #d97706; font-weight: 600;">
                    <i class="fa-solid fa-bookmark" style="font-size: 10px;"></i> {{ $stats['booked_slots'] ?? 0 }} Booked
                </span>
            </div>
        </div>

        <!-- Card 2: Doctors -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #059669;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                        Medical Specialists
                    </span>
                    <strong style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        {{ $stats['total_doctors'] ?? 0 }}
                    </strong>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
            </div>
            <div style="display: flex; gap: 12px; font-size: 12px; color: #64748b; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                <span style="display: flex; align-items: center; gap: 4px; color: #059669; font-weight: 600;">
                    <i class="fa-solid fa-circle" style="font-size: 8px;"></i> {{ $stats['active_doctors'] ?? 0 }} Active On Duty
                </span>
            </div>
        </div>

        <!-- Card 3: Pharmacy -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #d97706;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                        Pharmacy Catalog
                    </span>
                    <strong style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        {{ $stats['medicines'] ?? 0 }}
                    </strong>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-prescription-bottle-medical"></i>
                </div>
            </div>
            <div style="display: flex; gap: 12px; font-size: 12px; color: #64748b; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                <span style="display: flex; align-items: center; gap: 4px; color: #475569; font-weight: 500;">
                    <i class="fa-solid fa-boxes-stacked" style="font-size: 10px;"></i> Listed Medicines
                </span>
            </div>
        </div>

        <!-- Card 4: Laboratory -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #7c3aed;"></div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                <div>
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                        Laboratory Tests
                    </span>
                    <strong style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        {{ $stats['lab_tests'] ?? 0 }}
                    </strong>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #faf5ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
            </div>
            <div style="display: flex; gap: 12px; font-size: 12px; color: #64748b; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                <span style="display: flex; align-items: center; gap: 4px; color: #475569; font-weight: 500;">
                    <i class="fa-solid fa-microscope" style="font-size: 10px;"></i> Diagnostic Tests
                </span>
            </div>
        </div>

    </div>

    <!-- Charts & Analytics Section (2-Column Grid) -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 28px;">
        
        <!-- Activity Timeline Chart Card -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                        Hospital Activity Trends
                    </h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Daily volume across medical departments</p>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; font-size: 12px; font-weight: 600;">
                    <span style="display: flex; align-items: center; gap: 6px; color: #2563eb;">
                        <span style="width: 10px; height: 10px; border-radius: 3px; background: #2563eb;"></span> Appointments
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; color: #059669;">
                        <span style="width: 10px; height: 10px; border-radius: 3px; background: #059669;"></span> Pharmacy
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; color: #7c3aed;">
                        <span style="width: 10px; height: 10px; border-radius: 3px; background: #7c3aed;"></span> Lab Tests
                    </span>
                </div>
            </div>

            <!-- SVG Vector Chart with Smooth Area Fill -->
            <div style="width: 100%; height: 220px;">
                <svg viewBox="0 0 600 200" style="width: 100%; height: 100%; overflow: visible;" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="blueGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2563eb" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#2563eb" stop-opacity="0.0"/>
                        </linearGradient>
                        <linearGradient id="greenGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#059669" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#059669" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>

                    <!-- Horizontal Grid Lines -->
                    <line x1="30" y1="20" x2="590" y2="20" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="30" y1="60" x2="590" y2="60" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="30" y1="100" x2="590" y2="100" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="30" y1="140" x2="590" y2="140" stroke="#f1f5f9" stroke-width="1.5" />
                    <line x1="30" y1="180" x2="590" y2="180" stroke="#e2e8f0" stroke-width="1.5" />

                    <!-- Y-Axis Labels -->
                    <text x="10" y="24" fill="#94a3b8" font-size="11" font-family="inherit">50</text>
                    <text x="10" y="64" fill="#94a3b8" font-size="11" font-family="inherit">40</text>
                    <text x="10" y="104" fill="#94a3b8" font-size="11" font-family="inherit">30</text>
                    <text x="10" y="144" fill="#94a3b8" font-size="11" font-family="inherit">20</text>
                    <text x="10" y="184" fill="#94a3b8" font-size="11" font-family="inherit">10</text>

                    <!-- X-Axis Labels -->
                    <text x="50" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Mon</text>
                    <text x="140" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Tue</text>
                    <text x="230" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Wed</text>
                    <text x="320" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Thu</text>
                    <text x="410" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Fri</text>
                    <text x="500" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Sat</text>
                    <text x="570" y="198" fill="#64748b" font-size="11" font-weight="600" font-family="inherit">Sun</text>

                    <!-- Area Fills -->
                    <polygon fill="url(#blueGrad)" points="60,100 150,75 240,110 330,45 420,70 510,35 580,65 580,180 60,180" />

                    <!-- Blue Line (Appointments) -->
                    <polyline fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                              points="60,100 150,75 240,110 330,45 420,70 510,35 580,65" />
                    <circle cx="60" cy="100" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="150" cy="75" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="240" cy="110" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="330" cy="45" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="420" cy="70" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="510" cy="35" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />
                    <circle cx="580" cy="65" r="4" fill="#ffffff" stroke="#2563eb" stroke-width="2.5" />

                    <!-- Green Line (Pharmacy) -->
                    <polyline fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                              points="60,130 150,115 240,130 330,95 420,110 510,90 580,100" />

                    <!-- Purple Line (Lab) -->
                    <polyline fill="none" stroke="#7c3aed" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                              points="60,155 150,145 240,160 330,135 420,150 510,130 580,125" />
                </svg>
            </div>
        </div>

        <!-- Department Breakdown Donut Card -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column;">
            <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                Resource Distribution
            </h3>
            <p style="font-size: 13px; color: #64748b; margin: 0 0 20px 0;">Active service allocation</p>

            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 24px;">
                <div style="width: 140px; height: 140px; border-radius: 50%; background: conic-gradient(#2563eb 0% 48%, #059669 48% 78%, #7c3aed 78% 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(0,0,0,0.08);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; background: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1;">
                            {{ ($stats['appointments'] ?? 0) + ($stats['medicines'] ?? 0) + ($stats['lab_tests'] ?? 0) }}
                        </span>
                        <span style="font-size: 10px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-top: 2px;">Total Items</span>
                    </div>
                </div>
            </div>

            <!-- Breakdown Rows with Progress Bars -->
            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: auto;">
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: #1e293b; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 2px; background: #2563eb;"></span> Doctor Schedules
                        </span>
                        <span style="color: #2563eb;">{{ $stats['appointments'] ?? 0 }}</span>
                    </div>
                    <div style="height: 6px; border-radius: 99px; background: #f1f5f9; overflow: hidden;">
                        <div style="width: 55%; height: 100%; background: #2563eb; border-radius: 99px;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: #1e293b; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 2px; background: #059669;"></span> Medicines In Stock
                        </span>
                        <span style="color: #059669;">{{ $stats['medicines'] ?? 0 }}</span>
                    </div>
                    <div style="height: 6px; border-radius: 99px; background: #f1f5f9; overflow: hidden;">
                        <div style="width: 30%; height: 100%; background: #059669; border-radius: 99px;"></div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12.5px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: #1e293b; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 2px; background: #7c3aed;"></span> Lab Test Types
                        </span>
                        <span style="color: #7c3aed;">{{ $stats['lab_tests'] ?? 0 }}</span>
                    </div>
                    <div style="height: 6px; border-radius: 99px; background: #f1f5f9; overflow: hidden;">
                        <div style="width: 15%; height: 100%; background: #7c3aed; border-radius: 99px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Shortcuts & Recent Schedules (2-Column Grid) -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Recent Schedules Table -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 2px 0;">
                        Recent Appointment Schedules
                    </h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Latest consultation hours created</p>
                </div>
                <a href="{{ route('admin.appointments.index') }}" style="font-size: 13px; font-weight: 600; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                    View All <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                </a>
            </div>

            @if(isset($recentSchedules) && $recentSchedules->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13.5px; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1.5px solid #f1f5f9; color: #64748b; font-size: 12px; text-transform: uppercase;">
                                <th style="padding: 10px 12px; font-weight: 600;">Doctor</th>
                                <th style="padding: 10px 12px; font-weight: 600;">Date & Time</th>
                                <th style="padding: 10px 12px; font-weight: 600;">Fee (XAF)</th>
                                <th style="padding: 10px 12px; font-weight: 600;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSchedules as $sch)
                                <tr style="border-bottom: 1px solid #f8fafc;">
                                    <td style="padding: 12px; font-weight: 600; color: #0f172a;">
                                        Dr. {{ $sch->doctor->doctor_name ?? 'Specialist' }}
                                    </td>
                                    <td style="padding: 12px; color: #475569;">
                                        {{ \Carbon\Carbon::parse($sch->date)->format('M d, Y') }} 
                                        <span style="font-size: 12px; color: #94a3b8;">({{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }})</span>
                                    </td>
                                    <td style="padding: 12px; font-weight: 600; color: #0f172a;">
                                        {{ number_format($sch->price ?? 0, 0, ',', ' ') }}
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($sch->status === 'available')
                                            <span style="background: #ecfdf5; color: #059669; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 99px; display: inline-flex; align-items: center; gap: 4px;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669;"></span> Available
                                            </span>
                                        @elseif($sch->status === 'booked')
                                            <span style="background: #fffbeb; color: #d97706; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 99px; display: inline-flex; align-items: center; gap: 4px;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #d97706;"></span> Booked
                                            </span>
                                        @else
                                            <span style="background: #fef2f2; color: #dc2626; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 99px; display: inline-flex; align-items: center; gap: 4px;">
                                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #dc2626;"></span> Closed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13.5px;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 28px; margin-bottom: 8px; display: block; color: #cbd5e1;"></i>
                    No appointment schedules created yet.
                </div>
            @endif
        </div>

        <!-- Quick Administration Actions -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column;">
            <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                Quick Management
            </h3>
            <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0;">Fast shortcuts for admin tasks</p>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('admin.appointments.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; color: #0f172a; font-weight: 600; font-size: 13.5px; transition: all 0.15s;">
                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <span>Schedule Doctor Slot</span>
                    <i class="fa-solid fa-chevron-right" style="margin-left: auto; font-size: 11px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('admin.doctors.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; color: #0f172a; font-weight: 600; font-size: 13.5px; transition: all 0.15s;">
                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <span>Manage Doctor Accounts</span>
                    <i class="fa-solid fa-chevron-right" style="margin-left: auto; font-size: 11px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('admin.medicines.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; color: #0f172a; font-weight: 600; font-size: 13.5px; transition: all 0.15s;">
                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                        <i class="fa-solid fa-pills"></i>
                    </div>
                    <span>Pharmacy Inventory</span>
                    <i class="fa-solid fa-chevron-right" style="margin-left: auto; font-size: 11px; color: #94a3b8;"></i>
                </a>

                <a href="{{ route('admin.lab_tests.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; color: #0f172a; font-weight: 600; font-size: 13.5px; transition: all 0.15s;">
                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #faf5ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                        <i class="fa-solid fa-vial"></i>
                    </div>
                    <span>Diagnostic Lab Tests</span>
                    <i class="fa-solid fa-chevron-right" style="margin-left: auto; font-size: 11px; color: #94a3b8;"></i>
                </a>
            </div>
        </div>

    </div>

</section>

@endsection