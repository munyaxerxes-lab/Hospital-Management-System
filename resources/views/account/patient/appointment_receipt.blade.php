<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt - APT-{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 30px 16px 60px;
            min-height: 100vh;
        }

        .receipt-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Action Toolbar */
        .receipt-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .receipt-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            background: #ffffff;
            padding: 9px 16px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .receipt-back-link:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .toolbar-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-print:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        /* Receipt Card */
        .receipt-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 48px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .receipt-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #1e3a8a, #2563eb, #38bdf8);
        }

        /* Header */
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 28px;
            border-bottom: 2px solid #f1f5f9;
            gap: 20px;
        }

        .hospital-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .hospital-logo {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.25);
        }

        .hospital-details h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .hospital-details p {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        .receipt-meta {
            text-align: right;
        }

        .receipt-tag {
            display: inline-block;
            background: #dcfce7;
            color: #15803d;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .receipt-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .receipt-date {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Two-column Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 28px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-block h3 {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .info-value-main {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .info-value-sub {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

        /* Table of Services */
        .receipt-table-wrap {
            padding: 28px 0;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 8px;
        }

        .receipt-table th:last-child {
            text-align: right;
        }

        .receipt-table td {
            padding: 16px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .receipt-table td:last-child {
            text-align: right;
            font-weight: 700;
            color: #0f172a;
        }

        .service-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .service-desc {
            font-size: 12px;
            color: #64748b;
        }

        /* Totals */
        .receipt-totals {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .totals-box {
            width: 320px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px;
            border: 1px solid #e2e8f0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
            color: #64748b;
        }

        .total-row.grand {
            border-top: 1.5px solid #cbd5e1;
            margin-top: 8px;
            padding-top: 12px;
            font-size: 16px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .total-row.grand span:last-child {
            color: #2563eb;
            font-size: 18px;
        }

        /* Instructions & QR Bar */
        .receipt-footer-section {
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .instructions-box {
            flex: 1;
            min-width: 260px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }

        .instructions-box strong {
            color: #0f172a;
        }

        .qr-placeholder {
            text-align: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
        }

        .barcode {
            font-family: 'JetBrains Mono', monospace;
            font-size: 18px;
            letter-spacing: 4px;
            color: #0f172a;
            font-weight: 800;
        }

        .qr-placeholder span {
            display: block;
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Print Styling */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .receipt-toolbar {
                display: none !important;
            }

            .receipt-card {
                box-shadow: none !important;
                border: none !important;
                padding: 20px 0 !important;
            }
        }
    </style>
</head>
<body>

<div class="receipt-wrapper">

    {{-- Toolbar --}}
    <div class="receipt-toolbar">
        <a href="{{ route('patient.appointments') }}" class="receipt-back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Appointments
        </a>

        <div class="toolbar-actions">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa-solid fa-print"></i> Print / Save as PDF
            </button>
        </div>
    </div>

    {{-- Printable Receipt --}}
    <div class="receipt-card">

        {{-- Header --}}
        <div class="receipt-header">
            <div class="hospital-brand">
                <div class="hospital-logo">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div class="hospital-details">
                    <h1>MediLink Hospital</h1>
                    <p>Clinical Excellence & Compassionate Care</p>
                    <p>Douala, Cameroon &nbsp;•&nbsp; info@medilink.cm &nbsp;•&nbsp; +237 670 000 000</p>
                </div>
            </div>

            <div class="receipt-meta">
                <div class="receipt-tag">✓ Confirmed Booking</div>
                <div class="receipt-number">APT-{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="receipt-date">Issued: {{ now()->format('d M Y, H:i') }}</div>
            </div>
        </div>

        {{-- Patient & Doctor Information --}}
        <div class="info-grid">
            <div class="info-block">
                <h3>Patient Details</h3>
                <div class="info-value-main">{{ $appointment->patient?->user?->name ?? 'Patient' }}</div>
                <div class="info-value-sub">
                    <strong>Email:</strong> {{ $appointment->patient?->user?->email ?? 'N/A' }}<br>
                    <strong>Phone:</strong> {{ $appointment->patient?->user?->phone ?? 'N/A' }}<br>
                    <strong>Patient ID:</strong> PAT-{{ str_pad($appointment->patient_id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="info-block">
                <h3>Consultation Specialist</h3>
                <div class="info-value-main">Dr. {{ $appointment->doctor?->doctor_name ?? 'Specialist' }}</div>
                <div class="info-value-sub">
                    <strong>Specialty:</strong> {{ $appointment->doctor?->specialty ?? 'General Practice' }}<br>
                    <strong>Qualifications:</strong> {{ $appointment->doctor?->qualification ?? 'Certified Medical Practitioner' }}<br>
                    <strong>Experience:</strong> {{ $appointment->doctor?->years_of_experience ?? 5 }} Years
                </div>
            </div>
        </div>

        {{-- Consultation Details Table --}}
        <div class="receipt-table-wrap">
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Item & Description</th>
                        <th>Schedule / Slot</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="service-title">Doctor Consultation Session</div>
                            <div class="service-desc">
                                Reason: {{ $appointment->reason ?? 'General Medical Review & Consultation' }}
                            </div>
                        </td>
                        <td>
                            @if($appointment->doctor_schedule)
                                <strong>{{ \Carbon\Carbon::parse($appointment->doctor_schedule->date)->format('d M Y') }}</strong><br>
                                <span style="color:#64748b; font-size:12px;">{{ $appointment->doctor_schedule->start_time }} – {{ $appointment->doctor_schedule->end_time }}</span>
                            @else
                                {{ $appointment->created_at->format('d M Y, H:i') }}
                            @endif
                        </td>
                        @php
                            $fee = $appointment->doctor_schedule?->price ?? $appointment->doctor?->consultation_fee ?? 0;
                        @endphp
                        <td>{{ number_format($fee, 0, '.', ' ') }} FCFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        <div class="receipt-totals">
            <div class="totals-box">
                <div class="total-row">
                    <span>Consultation Fee:</span>
                    <span>{{ number_format($fee, 0, '.', ' ') }} FCFA</span>
                </div>
                <div class="total-row">
                    <span>Tax / VAT (0%):</span>
                    <span>0 FCFA</span>
                </div>
                <div class="total-row grand">
                    <span>Total Amount:</span>
                    <span>{{ number_format($fee, 0, '.', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- Footer & Barcode --}}
        <div class="receipt-footer-section">
            <div class="instructions-box">
                <strong>Important Clinic Instructions:</strong><br>
                1. Please arrive at least 15 minutes before your scheduled appointment time.<br>
                2. Show this official digital or printed receipt at the clinic reception desk.<br>
                3. For rescheduling or cancellations, please contact the hospital administration at least 4 hours in advance.
            </div>

            <div class="qr-placeholder">
                <div class="barcode">||| | |||| | ||| |||| |</div>
                <span>APT-{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

    </div>

</div>

</body>
</html>
