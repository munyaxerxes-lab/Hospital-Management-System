<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Request Confirmation</title>
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
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
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
            color: #99f6e4;
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
            background-color: #f0fdfa;
            color: #0f766e;
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
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 20px 0 8px;
        }
        .test-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background-color: #f0fdfa;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .test-name {
            font-weight: 600;
            color: #0f172a;
        }
        .test-price {
            font-weight: 700;
            color: #0d9488;
        }
        .total-row {
            background-color: #f0fdfa;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-row .total-label {
            font-weight: 700;
            color: #0f766e;
            font-size: 15px;
        }
        .total-row .total-value {
            font-weight: 800;
            color: #0d9488;
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
            <p>Laboratory Test Request — Official Confirmation</p>
        </div>

        <div class="body">
            @if($recipientType === 'admin')
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-admin">🔬 Lab Alert</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">New Lab Request Submitted</h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    A patient has submitted a new laboratory test request. Please review and process the request below.
                </p>
            @else
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-success">✓ Request Received</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">
                    Hello {{ $labRequest->user?->name ?? $labRequest->patient?->user?->name ?? 'Patient' }},
                </h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    Your laboratory test request has been received and is now being processed. Our lab technicians will attend to it promptly.
                </p>
            @endif

            {{-- Booking Details --}}
            <div class="receipt-box">
                <div class="row">
                    <span class="row-label">Request Number</span>
                    <span class="row-value">{{ $labRequest->request_number }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Name</span>
                    <span class="row-value">{{ $labRequest->user?->name ?? $labRequest->patient?->user?->name ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Email</span>
                    <span class="row-value">{{ $labRequest->user?->email ?? $labRequest->patient?->user?->email ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Scheduled Date</span>
                    <span class="row-value">
                        @if($labRequest->scheduled_date)
                            {{ \Carbon\Carbon::parse($labRequest->scheduled_date)->format('l, d F Y') }}
                        @else
                            To be confirmed
                        @endif
                    </span>
                </div>
                <div class="row">
                    <span class="row-label">Scheduled Time</span>
                    <span class="row-value">{{ $labRequest->scheduled_time ?? 'To be confirmed' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Sample Location</span>
                    <span class="row-value">{{ $labRequest->address ?? 'Hospital Laboratory Department' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Payment Method</span>
                    <span class="row-value">{{ ucwords(str_replace('_', ' ', $labRequest->payment_method ?? 'Cash on Delivery')) }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Status</span>
                    <span class="row-value" style="color: #d97706;">{{ ucfirst($labRequest->status ?? 'Pending') }}</span>
                </div>
                @if($labRequest->notes)
                <div class="row">
                    <span class="row-label">Notes</span>
                    <span class="row-value">{{ $labRequest->notes }}</span>
                </div>
                @endif
            </div>

            {{-- Tests Ordered --}}
            @if($labRequest->items && $labRequest->items->count() > 0)
                <div class="section-title">🧪 Tests Ordered</div>
                @foreach($labRequest->items as $item)
                    <div class="test-item">
                        <span class="test-name">{{ $item->test_name ?? $item->test?->name ?? 'Lab Test' }}</span>
                        <span class="test-price">{{ number_format($item->price ?? 0, 0, '.', ' ') }} FCFA</span>
                    </div>
                @endforeach
            @endif

            <div class="total-row">
                <span class="total-label">Total Amount</span>
                <span class="total-value">{{ number_format($labRequest->total_amount ?? 0, 0, '.', ' ') }} FCFA</span>
            </div>

            @if($recipientType !== 'admin')
                <div class="info-card">
                    <strong>📋 What happens next?</strong><br>
                    Our lab team will review your request and prepare for sample collection. Please be available at the indicated address/time. You will be notified once results are ready.
                </div>
            @endif
        </div>

        <div class="footer">
            <p style="margin: 0 0 6px;">MediLink Hospital Management System</p>
            <p style="margin: 0;">Need assistance? Contact our 24/7 helpline or reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
