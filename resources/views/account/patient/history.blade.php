@extends('layout.index')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ===========================
   HISTORY PAGE - PREMIUM UI
=========================== */
:root {
  --hist-bg: #ffffff;
  --hist-surface: #ffffff;
  --hist-card: #ffffff;
  --hist-border: #e2ecf8;
  --hist-accent: #2864e8;
  --hist-accent2: #28a55c;
  --hist-warn: #f59e0b;
  --hist-danger: #ef4444;
  --hist-text: #1a2340;
  --hist-muted: #6b7a99;
  --hist-radius: 16px;
}


.hist-page {
  font-family: 'Inter', sans-serif;
  background: var(--hist-bg);
  min-height: 100vh;
  padding: 32px 24px 60px;
  color: var(--hist-text);
}

/* ---- Header ---- */
.hist-header {
  max-width: 1100px;
  margin: 0 auto 32px;
}
.hist-header h1 {
  font-size: 28px;
  font-weight: 700;
  margin: 0 0 6px;
  background: linear-gradient(135deg, #1a2340 0%, var(--hist-accent) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.hist-header p {
  color: var(--hist-muted);
  font-size: 14px;
  margin: 0;
}

/* ---- Stats Row ---- */
.hist-stats {
  max-width: 1100px;
  margin: 0 auto 28px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 14px;
}
.hist-stat-card {
  background: var(--hist-card);
  border: 1px solid var(--hist-border);
  border-radius: var(--hist-radius);
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  box-shadow: 0 1px 6px rgba(40,100,232,0.07);
}
.hist-stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.hist-stat-icon.lab    { background: rgba(108,99,255,0.15); color: var(--hist-accent); }
.hist-stat-icon.pharma { background: rgba(0,212,170,0.12);  color: var(--hist-accent2); }
.hist-stat-icon.appt   { background: rgba(245,158,11,0.12); color: var(--hist-warn); }
.hist-stat-text strong { display: block; font-size: 22px; font-weight: 700; }
.hist-stat-text span   { font-size: 12px; color: var(--hist-muted); }

/* ---- Tabs ---- */
.hist-tabs-wrap {
  max-width: 1100px;
  margin: 0 auto 24px;
}
.hist-tabs {
  display: inline-flex;
  background: var(--hist-card);
  border: 1px solid var(--hist-border);
  border-radius: 12px;
  padding: 4px;
  gap: 4px;
}
.hist-tab-btn {
  background: transparent;
  border: none;
  color: var(--hist-muted);
  font-family: 'Inter', sans-serif;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 20px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 7px;
  white-space: nowrap;
}
.hist-tab-btn:hover { color: var(--hist-text); background: rgba(255,255,255,0.05); }
.hist-tab-btn.active {
  background: var(--hist-accent);
  color: #fff;
  box-shadow: 0 4px 14px rgba(108,99,255,0.35);
}
.hist-tab-btn .tab-count {
  background: rgba(255,255,255,0.2);
  border-radius: 20px;
  padding: 1px 7px;
  font-size: 11px;
  font-weight: 600;
}
.hist-tab-btn.active .tab-count { background: rgba(255,255,255,0.25); }

/* ---- Panels ---- */
.hist-panel { display: none; max-width: 1100px; margin: 0 auto; }
.hist-panel.active { display: block; }

/* ---- Empty State ---- */
.hist-empty {
  background: var(--hist-card);
  border: 1px dashed var(--hist-border);
  border-radius: var(--hist-radius);
  padding: 56px 24px;
  text-align: center;
}
.hist-empty i { font-size: 48px; color: var(--hist-muted); margin-bottom: 14px; display: block; }
.hist-empty h3 { margin: 0 0 8px; font-size: 16px; color: var(--hist-text); }
.hist-empty p  { margin: 0 0 20px; font-size: 13px; color: var(--hist-muted); }
.hist-empty a  {
  display: inline-flex; align-items: center; gap: 6px;
  background: var(--hist-accent); color: #fff;
  padding: 10px 22px; border-radius: 8px;
  text-decoration: none; font-size: 13px; font-weight: 600;
  transition: opacity 0.2s;
}
.hist-empty a:hover { opacity: 0.85; }

/* ---- History Card ---- */
.hist-card {
  background: var(--hist-card);
  border: 1px solid var(--hist-border);
  border-radius: var(--hist-radius);
  margin-bottom: 16px;
  overflow: hidden;
  transition: border-color 0.2s, box-shadow 0.2s;
  box-shadow: 0 2px 10px rgba(40,100,232,0.07);
}
.hist-card:hover { border-color: rgba(40,100,232,0.35); box-shadow: 0 4px 18px rgba(40,100,232,0.12); }

.hist-row {
  display: grid;
  grid-template-columns: 2fr 1.3fr 2fr 1.2fr auto;
  align-items: center;
  gap: 12px;
  padding: 18px 20px;
}

/* ID column */
.hist-id {
  display: flex;
  align-items: center;
  gap: 12px;
}
.hist-id-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}
.hist-id-icon.lab    { background: rgba(108,99,255,0.15); color: var(--hist-accent); }
.hist-id-icon.pharma { background: rgba(0,212,170,0.12);  color: var(--hist-accent2); }
.hist-id-icon.appt   { background: rgba(245,158,11,0.12); color: var(--hist-warn); }
.hist-id-code { font-size: 13px; font-weight: 600; color: var(--hist-text); display: block; }
.hist-id-type { font-size: 11px; color: var(--hist-muted); }

/* Date column */
.hist-date-main { font-size: 13px; font-weight: 500; }
.hist-date-sub  { font-size: 11px; color: var(--hist-muted); }

/* Description */
.hist-desc-main { font-size: 13px; font-weight: 500; }
.hist-desc-sub  { font-size: 11px; color: var(--hist-muted); margin-top: 3px; }

/* Status badges */
.hist-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
  white-space: nowrap;
}
.hist-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
.hist-badge.pending     { background: rgba(245,158,11,0.12); color: var(--hist-warn); }
.hist-badge.processing  { background: rgba(59,130,246,0.12); color: #60a5fa; }
.hist-badge.sample_collected { background: rgba(139,92,246,0.12); color: #a78bfa; }
.hist-badge.delivered   { background: rgba(0,212,170,0.12);  color: var(--hist-accent2); }
.hist-badge.completed   { background: rgba(0,212,170,0.12);  color: var(--hist-accent2); }
.hist-badge.cancelled   { background: rgba(239,68,68,0.12);  color: var(--hist-danger); }

/* Toggle button */
.hist-toggle-btn {
  background: rgba(255,255,255,0.05);
  border: 1px solid var(--hist-border);
  color: var(--hist-text);
  font-family: 'Inter', sans-serif;
  font-size: 12px;
  font-weight: 500;
  padding: 7px 14px;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 5px;
  transition: all 0.2s;
  white-space: nowrap;
}
.hist-toggle-btn:hover { background: rgba(108,99,255,0.15); border-color: var(--hist-accent); }
.hist-toggle-btn i { transition: transform 0.3s; }
.hist-toggle-btn.open i { transform: rotate(180deg); }

/* Details section */
.hist-details {
  display: none;
  border-top: 1px solid var(--hist-border);
  background: #f7fbff;
}
.hist-details.show { display: block; }

.hist-details-inner {
  padding: 24px 20px;
}
.hist-details-title {
  font-size: 13px;
  font-weight: 600;
  color: var(--hist-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 16px;
}
.hist-detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
}
.hist-detail-box {
  background: var(--hist-surface);
  border: 1px solid var(--hist-border);
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 1px 4px rgba(40,100,232,0.05);
}
.hist-detail-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--hist-muted);
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 6px;
}
.hist-detail-value {
  font-size: 13px;
  color: var(--hist-text);
  font-weight: 500;
}
.hist-detail-value.amount {
  font-size: 18px;
  font-weight: 700;
  color: var(--hist-accent2);
}

/* Items list inside details */
.hist-items-list { list-style: none; margin: 0; padding: 0; }
.hist-items-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 7px 0;
  border-bottom: 1px solid var(--hist-border);
  font-size: 12px;
}
.hist-items-list li:last-child { border-bottom: none; }
.hist-items-list .item-name { color: var(--hist-text); }
.hist-items-list .item-price { color: var(--hist-accent2); font-weight: 600; }

/* Result section */
.hist-result-section {
  margin-top: 16px;
  background: linear-gradient(135deg, rgba(0,212,170,0.08), rgba(108,99,255,0.08));
  border: 1px solid rgba(0,212,170,0.2);
  border-radius: 12px;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}
.hist-result-info { display: flex; align-items: center; gap: 12px; }
.hist-result-icon {
  width: 40px; height: 40px; border-radius: 10px;
  background: rgba(0,212,170,0.15);
  color: var(--hist-accent2);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.hist-result-text strong { display: block; font-size: 13px; color: var(--hist-text); }
.hist-result-text span { font-size: 11px; color: var(--hist-muted); }
.hist-download-btn {
  display: inline-flex; align-items: center; gap: 7px;
  background: var(--hist-accent2); color: #ffffff;
  padding: 9px 18px; border-radius: 8px;
  text-decoration: none; font-size: 13px; font-weight: 700;
  transition: opacity 0.2s; white-space: nowrap;
}
.hist-download-btn:hover { opacity: 0.85; }

.hist-result-notes {
  margin-top: 12px;
  background: #edf4ff;
  border-radius: 8px;
  padding: 12px;
  font-size: 13px;
  color: var(--hist-muted);
  line-height: 1.6;
  width: 100%;
}
.hist-result-notes strong { color: var(--hist-text); }

/* Pending result placeholder */
.hist-result-pending {
  margin-top: 16px;
  background: rgba(245,158,11,0.08);
  border: 1px dashed rgba(245,158,11,0.25);
  border-radius: 12px;
  padding: 14px 18px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: var(--hist-warn);
}

/* ---- Responsive ---- */
@media (max-width: 768px) {
  .hist-row {
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }
  .hist-row > *:nth-child(3) { grid-column: span 2; }
  .hist-row > *:nth-child(4) { }
  .hist-row > *:nth-child(5) { justify-self: end; }
  .hist-stats { grid-template-columns: repeat(3, 1fr); }
  .hist-tabs { flex-wrap: wrap; }
}
@media (max-width: 520px) {
  .hist-row { grid-template-columns: 1fr; }
  .hist-row > *:nth-child(3) { grid-column: span 1; }
  .hist-stats { grid-template-columns: 1fr; }
  .hist-page { padding: 20px 16px 60px; }
}
</style>

<div class="hist-page">

  {{-- ===== HEADER ===== --}}
  <div class="hist-header">
    <h1>My Health History</h1>
    <p>Track all your lab tests, pharmacy orders, and appointments in one place.</p>
  </div>

  {{-- ===== STATS ===== --}}
  <div class="hist-stats">
    <div class="hist-stat-card">
      <div class="hist-stat-icon lab"><i class="ri-flask-line"></i></div>
      <div class="hist-stat-text">
        <strong>{{ $labRequests->count() }}</strong>
        <span>Lab Requests</span>
      </div>
    </div>
    <div class="hist-stat-card">
      <div class="hist-stat-icon pharma"><i class="ri-capsule-fill"></i></div>
      <div class="hist-stat-text">
        <strong>{{ $orders->count() }}</strong>
        <span>Pharmacy Orders</span>
      </div>
    </div>
    <div class="hist-stat-card">
      <div class="hist-stat-icon appt"><i class="ri-calendar-event-line"></i></div>
      <div class="hist-stat-text">
        <strong>{{ $appointments->count() }}</strong>
        <span>Appointments</span>
      </div>
    </div>
  </div>

  {{-- ===== TABS ===== --}}
  <div class="hist-tabs-wrap">
    <div class="hist-tabs">
      <button class="hist-tab-btn active" onclick="showTab('lab', this)" id="tab-lab">
        <i class="ri-flask-line"></i> Lab Tests
        <span class="tab-count">{{ $labRequests->count() }}</span>
      </button>
      <button class="hist-tab-btn" onclick="showTab('pharma', this)" id="tab-pharma">
        <i class="ri-capsule-fill"></i> Pharmacy
        <span class="tab-count">{{ $orders->count() }}</span>
      </button>
      <button class="hist-tab-btn" onclick="showTab('appt', this)" id="tab-appt">
        <i class="ri-calendar-event-line"></i> Appointments
        <span class="tab-count">{{ $appointments->count() }}</span>
      </button>
    </div>
  </div>

  {{-- =====================
       TAB: LAB TESTS
  ===================== --}}
  <div class="hist-panel active" id="panel-lab">

    @if($labRequests->isEmpty())
      <div class="hist-empty">
        <i class="ri-flask-line"></i>
        <h3>No lab test requests yet</h3>
        <p>Book your first lab test and our team will come to you.</p>
        <a href="{{ url('/labtests') }}"><i class="ri-add-line"></i> Book a Lab Test</a>
      </div>
    @else
      @foreach($labRequests as $req)
        @php
          $statusClass = match($req->status) {
            'delivered','completed'   => 'delivered',
            'processing','sample_collected' => 'processing',
            'cancelled'               => 'cancelled',
            default                   => 'pending',
          };
          $statusLabel = match($req->status) {
            'sample_collected' => 'Sample Collected',
            'delivered'        => 'Delivered',
            'completed'        => 'Completed',
            'processing'       => 'Processing',
            'cancelled'        => 'Cancelled',
            default            => 'Pending',
          };
          $testNames = $req->items->pluck('test_name')->filter()->join(', ');
          $hasResult = (bool)$req->result_document;
        @endphp

        <div class="hist-card" id="lab-card-{{ $req->id }}">
          <div class="hist-row">

            {{-- ID --}}
            <div class="hist-id">
              <div class="hist-id-icon lab"><i class="ri-flask-line"></i></div>
              <div>
                <span class="hist-id-code">{{ $req->request_number }}</span>
                <span class="hist-id-type">Lab Test Request</span>
              </div>
            </div>

            {{-- Date --}}
            <div>
              <div class="hist-date-main">
                {{ $req->scheduled_date ? $req->scheduled_date->format('d M Y') : $req->created_at->format('d M Y') }}
              </div>
              <div class="hist-date-sub">{{ $req->scheduled_time ?? $req->created_at->format('h:i A') }}</div>
            </div>

            {{-- Description --}}
            <div>
              <div class="hist-desc-main">{{ $req->items->count() }} Test(s) Booked</div>
              <div class="hist-desc-sub" title="{{ $testNames }}">
                {{ Str::limit($testNames ?: 'General Lab Panel', 55) }}
              </div>
            </div>

            {{-- Status --}}
            <div>
              <span class="hist-badge {{ $statusClass }}">{{ $statusLabel }}</span>
              @if($hasResult)
                <div style="margin-top:5px;">
                  <span class="hist-badge completed" style="font-size:10px;">
                    <i class="ri-file-text-line" style="margin-right:2px;"></i> Result Ready
                  </span>
                </div>
              @endif
            </div>

            {{-- Toggle --}}
            <button class="hist-toggle-btn" onclick="toggleDetail('lab-detail-{{ $req->id }}', this)">
              <span>Details</span>
              <i class="ri-arrow-down-s-line"></i>
            </button>

          </div>

          {{-- Detail Panel --}}
          <div class="hist-details" id="lab-detail-{{ $req->id }}">
            <div class="hist-details-inner">
              <div class="hist-details-title">Lab Test Details — {{ $req->request_number }}</div>
              <div class="hist-detail-grid">

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Scheduled Date & Time</div>
                  <div class="hist-detail-value">
                    {{ $req->scheduled_date ? $req->scheduled_date->format('d M Y') : '—' }}
                    &nbsp;·&nbsp; {{ $req->scheduled_time ?? '—' }}
                  </div>
                  <br>
                  <div class="hist-detail-label">Collection Address</div>
                  <div class="hist-detail-value">{{ $req->address ?? 'Hospital Lab Department' }}</div>
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Tests Requested</div>
                  <ul class="hist-items-list">
                    @forelse($req->items as $item)
                      <li>
                        <span class="item-name">{{ $item->test_name }}</span>
                        <span class="item-price">{{ number_format($item->price, 0, '.', ' ') }} FCFA</span>
                      </li>
                    @empty
                      <li><span class="item-name" style="color:var(--hist-muted)">No items found</span></li>
                    @endforelse
                  </ul>
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Request ID</div>
                  <div class="hist-detail-value">{{ $req->request_number }}</div>
                  <br>
                  <div class="hist-detail-label">Payment Method</div>
                  <div class="hist-detail-value">{{ ucfirst(str_replace('_', ' ', $req->payment_method ?? 'cash')) }}</div>
                  <br>
                  <div class="hist-detail-label">Total Amount</div>
                  <div class="hist-detail-value amount">{{ number_format($req->total_amount, 0, '.', ' ') }} FCFA</div>
                </div>

              </div>

              {{-- ---- Result Section ---- --}}
              @if($hasResult)
                <div class="hist-result-section">
                  <div class="hist-result-info">
                    <div class="hist-result-icon">
                      @if($req->result_file_type === 'pdf')
                        <i class="ri-file-pdf-line"></i>
                      @elseif($req->result_file_type === 'word')
                        <i class="ri-file-word-line"></i>
                      @else
                        <i class="ri-image-line"></i>
                      @endif
                    </div>
                    <div class="hist-result-text">
                      <strong>Result Available — {{ $req->result_file_name ?? 'lab_result' }}</strong>
                      <span>Uploaded {{ $req->result_uploaded_at ? $req->result_uploaded_at->diffForHumans() : 'recently' }}</span>
                    </div>
                  </div>
                  <a class="hist-download-btn"
                     href="{{ route('patient.lab_results.download', $req->id) }}"
                     target="_blank">
                    <i class="ri-download-line"></i> Download Result
                  </a>
                  @if($req->result_notes)
                    <div class="hist-result-notes" style="margin-top:0; width:100%;">
                      <strong>Medical Notes:</strong><br>{{ $req->result_notes }}
                    </div>
                  @endif
                </div>
              @elseif(!in_array($req->status, ['cancelled']))
                <div class="hist-result-pending">
                  <i class="ri-time-line"></i>
                  <span>
                    @if($req->status === 'pending')
                      Your request is pending. Our team will contact you to schedule sample collection.
                    @elseif($req->status === 'sample_collected')
                      Sample collected — results are being processed in our laboratory.
                    @elseif($req->status === 'processing')
                      Your samples are being analysed. Results will be available soon.
                    @else
                      Results will be uploaded here once available.
                    @endif
                  </span>
                </div>
              @endif

              @if($req->notes)
                <div class="hist-result-notes" style="margin-top:12px;">
                  <strong>Your Notes:</strong><br>{{ $req->notes }}
                </div>
              @endif

            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

  {{-- =====================
       TAB: PHARMACY ORDERS
  ===================== --}}
  <div class="hist-panel" id="panel-pharma">

    @if($orders->isEmpty())
      <div class="hist-empty">
        <i class="ri-capsule-fill"></i>
        <h3>No pharmacy orders yet</h3>
        <p>Browse available medicines and place your first order.</p>
        <a href="{{ url('/pharmacy') }}"><i class="ri-add-line"></i> Browse Pharmacy</a>
      </div>
    @else
      @foreach($orders as $order)
        @php
          $oStatusClass = match($order->status) {
            'delivered','completed' => 'delivered',
            'processing'            => 'processing',
            'cancelled'             => 'cancelled',
            default                 => 'pending',
          };
          $oStatusLabel = ucfirst($order->status ?? 'pending');
          $itemCount = $order->items->count();
        @endphp
        <div class="hist-card">
          <div class="hist-row">

            <div class="hist-id">
              <div class="hist-id-icon pharma"><i class="ri-capsule-fill"></i></div>
              <div>
                <span class="hist-id-code">{{ $order->order_number }}</span>
                <span class="hist-id-type">Pharmacy Order</span>
              </div>
            </div>

            <div>
              <div class="hist-date-main">{{ $order->created_at->format('d M Y') }}</div>
              <div class="hist-date-sub">{{ $order->created_at->format('h:i A') }}</div>
            </div>

            <div>
              <div class="hist-desc-main">{{ $itemCount }} Medicine(s)</div>
              <div class="hist-desc-sub">
                {{ Str::limit($order->items->map(fn($i) => $i->medicine?->name ?? 'Item')->join(', '), 55) }}
              </div>
            </div>

            <div>
              <span class="hist-badge {{ $oStatusClass }}">{{ $oStatusLabel }}</span>
            </div>

            <button class="hist-toggle-btn" onclick="toggleDetail('pharma-detail-{{ $order->id }}', this)">
              <span>Details</span>
              <i class="ri-arrow-down-s-line"></i>
            </button>

          </div>

          <div class="hist-details" id="pharma-detail-{{ $order->id }}">
            <div class="hist-details-inner">
              <div class="hist-details-title">Order Details — {{ $order->order_number }}</div>
              <div class="hist-detail-grid">

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Delivery Address</div>
                  <div class="hist-detail-value">{{ $order->shipping_address ?? 'Not specified' }}</div>
                  @if($order->delivered_at)
                    <br>
                    <div class="hist-detail-label">Delivered On</div>
                    <div class="hist-detail-value">{{ $order->delivered_at->format('d M Y, h:i A') }}</div>
                  @endif
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Items Ordered</div>
                  <ul class="hist-items-list">
                    @foreach($order->items as $item)
                      <li>
                        <span class="item-name">
                          {{ $item->medicine?->name ?? 'Medicine' }}
                          @if($item->quantity > 1)
                            <span style="color:var(--hist-muted)">×{{ $item->quantity }}</span>
                          @endif
                        </span>
                        <span class="item-price">{{ number_format($item->total_price ?? $item->unit_price, 0, '.', ' ') }} FCFA</span>
                      </li>
                    @endforeach
                  </ul>
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Order ID</div>
                  <div class="hist-detail-value">{{ $order->order_number }}</div>
                  <br>
                  <div class="hist-detail-label">Payment Method</div>
                  <div class="hist-detail-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'cash')) }}</div>
                  <br>
                  <div class="hist-detail-label">Total Paid</div>
                  <div class="hist-detail-value amount">{{ number_format($order->total_amount, 0, '.', ' ') }} FCFA</div>
                </div>

              </div>

              @if($order->notes)
                <div class="hist-result-notes" style="margin-top:12px;">
                  <strong>Notes:</strong><br>{{ $order->notes }}
                </div>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

  {{-- =====================
       TAB: APPOINTMENTS
  ===================== --}}
  <div class="hist-panel" id="panel-appt">

    @if($appointments->isEmpty())
      <div class="hist-empty">
        <i class="ri-calendar-event-line"></i>
        <h3>No appointments yet</h3>
        <p>Book a consultation with one of our qualified doctors.</p>
        <a href="{{ url('/book') }}"><i class="ri-add-line"></i> Book Appointment</a>
      </div>
    @else
      @foreach($appointments as $appt)
        @php
          $aStatusClass = match($appt->status) {
            'completed'  => 'completed',
            'cancelled'  => 'cancelled',
            'confirmed'  => 'delivered',
            default      => 'pending',
          };
          $aStatusLabel = ucfirst($appt->status ?? 'pending');
          $doctor = $appt->doctor;
          $schedule = $appt->doctor_schedule;
        @endphp
        <div class="hist-card">
          <div class="hist-row">

            <div class="hist-id">
              <div class="hist-id-icon appt"><i class="ri-calendar-event-line"></i></div>
              <div>
                <span class="hist-id-code">APT-{{ str_pad($appt->id, 6, '0', STR_PAD_LEFT) }}</span>
                <span class="hist-id-type">Consultation</span>
              </div>
            </div>

            <div>
              <div class="hist-date-main">
                {{ $schedule ? \Carbon\Carbon::parse($schedule->date)->format('d M Y') : $appt->created_at->format('d M Y') }}
              </div>
              <div class="hist-date-sub">
                {{ $schedule->start_time ?? $appt->created_at->format('h:i A') }}
              </div>
            </div>

            <div>
              <div class="hist-desc-main">Dr. {{ $doctor?->doctor_name ?? 'Doctor' }}</div>
              <div class="hist-desc-sub">
                {{ $doctor?->specialty ?? 'General Practice' }}
              </div>
            </div>

            <div>
              <span class="hist-badge {{ $aStatusClass }}">{{ $aStatusLabel }}</span>
            </div>

            <button class="hist-toggle-btn" onclick="toggleDetail('appt-detail-{{ $appt->id }}', this)">
              <span>Details</span>
              <i class="ri-arrow-down-s-line"></i>
            </button>

          </div>

          <div class="hist-details" id="appt-detail-{{ $appt->id }}">
            <div class="hist-details-inner">
              <div class="hist-details-title">Appointment Details</div>
              <div class="hist-detail-grid">

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Doctor</div>
                  <div class="hist-detail-value">Dr. {{ $doctor?->doctor_name ?? '—' }}</div>
                  <br>
                  <div class="hist-detail-label">Specialization</div>
                  <div class="hist-detail-value">{{ $doctor?->specialty ?? 'General Practice' }}</div>
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Date & Time</div>
                  <div class="hist-detail-value">
                    @if($schedule)
                      {{ \Carbon\Carbon::parse($schedule->date ?? now())->format('d M Y') }}
                      &nbsp;·&nbsp; {{ $schedule->start_time ?? '—' }}
                    @else
                      {{ $appt->created_at->format('d M Y, h:i A') }}
                    @endif
                  </div>
                  <br>
                  <div class="hist-detail-label">Reason</div>
                  <div class="hist-detail-value">{{ $appt->reason ?? 'General Consultation' }}</div>
                </div>

                <div class="hist-detail-box">
                  <div class="hist-detail-label">Appointment ID</div>
                  <div class="hist-detail-value">APT-{{ str_pad($appt->id, 6, '0', STR_PAD_LEFT) }}</div>
                  <br>
                  <div class="hist-detail-label">Status</div>
                  <div class="hist-detail-value">
                    <span class="hist-badge {{ $aStatusClass }}">{{ $aStatusLabel }}</span>
                  </div>
                  <div style="margin-top:14px;">
                    <a href="{{ route('patient.appointment.receipt', $appt->id) }}" target="_blank" class="hist-download-btn" style="padding:7px 14px; font-size:12px; display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:#fff; text-decoration:none; border-radius:8px; font-weight:700;">
                      <i class="ri-file-download-line"></i> Download Receipt
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>

</div>

<script>
/* Tab switching */
function showTab(tab, btn) {
  document.querySelectorAll('.hist-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.hist-tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('panel-' + tab).classList.add('active');
  btn.classList.add('active');
}

/* Toggle detail section */
function toggleDetail(id, btn) {
  const detail = document.getElementById(id);
  const isOpen = detail.classList.contains('show');
  detail.classList.toggle('show', !isOpen);
  btn.classList.toggle('open', !isOpen);
  btn.querySelector('span').textContent = isOpen ? 'Details' : 'Close';
}
</script>

@endsection