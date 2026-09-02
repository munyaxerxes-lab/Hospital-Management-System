<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
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
            color: #ddd6fe;
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
            background-color: #f5f3ff;
            color: #6d28d9;
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
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background-color: #f5f3ff;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .item-left {
        }
        .item-name {
            font-weight: 600;
            color: #0f172a;
            display: block;
        }
        .item-qty {
            font-size: 12px;
            color: #64748b;
        }
        .item-price {
            font-weight: 700;
            color: #7c3aed;
            text-align: right;
        }
        .total-row {
            background-color: #f5f3ff;
            border-radius: 8px;
            padding: 12px 14px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-row .total-label {
            font-weight: 700;
            color: #5b21b6;
            font-size: 15px;
        }
        .total-row .total-value {
            font-weight: 800;
            color: #7c3aed;
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
            <p>Medicine Order — Official Confirmation &amp; Receipt</p>
        </div>

        <div class="body">
            @if($recipientType === 'admin')
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-admin">🛒 Order Alert</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">New Medicine Order Placed</h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    A patient has placed a new medicine order. Please review and process the dispatch below.
                </p>
            @else
                <div style="margin-bottom: 16px;">
                    <span class="badge badge-success">✓ Order Confirmed</span>
                </div>
                <h2 style="font-size: 18px; color: #0f172a; margin: 0 0 10px;">
                    Hello {{ $order->user?->name ?? $order->patient?->user?->name ?? 'Patient' }},
                </h2>
                <p style="font-size: 14px; color: #475569; margin: 0 0 18px;">
                    Thank you for your order! Your medicine request has been placed successfully and is now pending dispatch from our pharmacy.
                </p>
            @endif

            {{-- Order Summary --}}
            <div class="receipt-box">
                <div class="row">
                    <span class="row-label">Order Number</span>
                    <span class="row-value">{{ $order->order_number }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Name</span>
                    <span class="row-value">{{ $order->user?->name ?? $order->patient?->user?->name ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Patient Email</span>
                    <span class="row-value">{{ $order->user?->email ?? $order->patient?->user?->email ?? 'N/A' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Delivery Address</span>
                    <span class="row-value">{{ $order->shipping_address ?? 'Hospital Clinic / Patient Address' }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Payment Method</span>
                    <span class="row-value">{{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'Cash on Delivery')) }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Payment Status</span>
                    <span class="row-value" style="color: #d97706;">{{ ucfirst($order->payment_status ?? 'Pending') }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Order Status</span>
                    <span class="row-value" style="color: #2563eb;">{{ ucfirst($order->status ?? 'Pending') }}</span>
                </div>
                <div class="row">
                    <span class="row-label">Order Date</span>
                    <span class="row-value">{{ $order->created_at?->format('l, d F Y · H:i') ?? now()->format('l, d F Y · H:i') }}</span>
                </div>
                @if($order->notes)
                <div class="row">
                    <span class="row-label">Notes</span>
                    <span class="row-value">{{ $order->notes }}</span>
                </div>
                @endif
            </div>

            {{-- Items --}}
            @if($order->items && $order->items->count() > 0)
                <div class="section-title">💊 Items Ordered</div>
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-left">
                            <span class="item-name">{{ $item->medicine?->name ?? 'Medicine' }}</span>
                            <span class="item-qty">Qty: {{ $item->quantity }} × {{ number_format($item->unit_price ?? 0, 0, '.', ' ') }} FCFA</span>
                        </div>
                        <span class="item-price">{{ number_format($item->total_price ?? ($item->unit_price * $item->quantity), 0, '.', ' ') }} FCFA</span>
                    </div>
                @endforeach
            @endif

            <div class="total-row">
                <span class="total-label">Order Total</span>
                <span class="total-value">{{ number_format($order->total_amount ?? 0, 0, '.', ' ') }} FCFA</span>
            </div>

            @if($recipientType !== 'admin')
                <div class="info-card">
                    <strong>🚚 Delivery Information:</strong><br>
                    Our pharmacy team will process your order and arrange delivery. You will be notified once your order is dispatched. Please ensure someone is available at the delivery address.
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
