<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 24px;
            line-height: 1.5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            padding: 30px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 6px 0 0;
            font-size: 13px;
            color: #bfdbfe;
        }
        .body {
            padding: 28px 24px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-admin {
            background-color: #eff6ff;
            color: #1d4ed8;
        }
        .receipt-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
            margin: 20px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #cbd5e1;
            font-size: 14px;
        }
        .row:last-child {
            border-bottom: none;
        }
        .row-label {
            color: #64748b;
        }
        .row-value {
            font-weight: 600;
            color: #0f172a;
            text-align: right;
        }
        .total-row {
            background-color: #eff6ff;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-row .total-label {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 15px;
        }
        .total-row .total-value {
            font-weight: 800;
            color: #2563eb;
            font-size: 18px;
        }
        .info-card {
            background-color: #f0fdf4;
            border-left: 4px solid #22c55e;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #166534;
            margin: 18px 0;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
            margin: 10px 0;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 18px 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MediLink Hospital</h1>
            <p>Official Appointment Booking Confirmation & Receipt</p>
        </div>

        <div class="body">
            @if($recipientType === 'admin')
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-admin">Admin Alert</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">New Appointment Booked</h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    A patient has booked a new doctor consultation slot. Here are the booking details:
                </p>
            @else
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-success">✓ Confirmed</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">
                    Hello {{ $appointment->patient?->user?->name ?? 'Patient' }},
                </h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    Thank you for booking with MediLink. Your medical appointment has been registered successfully.
                </p>
            @endif

            <div class="receipt-box">
                <div class="row">
                    <span class="row-label">Receipt / Reference</span>
                    <span class="row-value">APT-{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Name</span>
                    <span class="row-value">{{ $appointment->patient?->user?->name ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Email</span>
                    <span class="row-value">{{ $appointment->patient?->user?->email ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Doctor</span>
                    <span class="row-value">Dr. {{ $appointment->doctor?->doctor_name ?? 'Doctor' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Specialty</span>
                    <span class="row-value">{{ $appointment->doctor?->specialty ?? 'General Medicine' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Scheduled Date</span>
                    <span class="row-value">
                        @if($appointment->doctor_schedule?->date)
                            {{ \Carbon\Carbon::parse($appointment->doctor_schedule->date)->format('l, d F Y') }}
                        @else
                            {{ $appointment->created_at->format('l, d F Y') }}
                        @endif
                    </span>
                </div>
                <div class="row">
                    <span class="row-label">Consultation Time</span>
                    <span class="row-value">
                        @if($appointment->doctor_schedule)
                            {{ $appointment->doctor_schedule->start_time }} – {{ $appointment->doctor_schedule->end_time }}
                        @else
                            Scheduled
                        @endif
                    </span>
                </div>
                <div class="row">
                    <span class="row-label">Reason / Notes</span>
                    <span class="row-value">{{ $appointment->reason ?? 'General Consultation' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Status</span>
                    <span class="row-value" style="color: #16a34a;">{{ ucfirst($appointment->status ?? 'Confirmed') }}</span>
                </div>

                @php
                    $fee = $appointment->doctor_schedule?->price ?? $appointment->doctor?->consultation_fee ?? 0;
                @endphp
                <div class="total-row">
                    <span class="total-label">Consultation Fee</span>
                    <span class="total-value">{{ number_format($fee, 0, '.', ' ') }} FCFA</span>
                </div>
            </div>

            <div class="info-card">
                <strong>📍 Clinic Instructions:</strong><br>
                Please arrive at least 15 minutes prior to your scheduled consultation time. Present this receipt at the front desk upon arrival.
            </div>

            <div style="text-align: center; margin: 24px 0;">
                <a href="{{ route('patient.appointment.receipt', $appointment->id) }}" class="btn">
                    📄 View & Download Full Receipt
                </a>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px;">MediLink Hospital Management System</p>
            <p style="margin: 0;">Need assistance? Contact our 24/7 helpline or reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
