@extends('layout.index')
@section('content')

<div class="cart-page-container">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->
    <div class="cart-page-header">
        <div class="cart-header-left">
            <a href="/pharmacy" class="back-to-shop">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Continue Shopping</span>
            </a>
            <div class="cart-title-block">
                <h1 class="cart-page-title">My Cart</h1>
                <p class="cart-page-subtitle">
                    @if(isset($carts) && $carts->count())
                        {{ $carts->sum('quantity') }} item{{ $carts->sum('quantity') !== 1 ? 's' : '' }} ready to order
                    @else
                        Your cart is empty
                    @endif
                </p>
            </div>
        </div>

        <!-- Progress Steps Indicator -->
        <div class="checkout-progress-steps">
            <div class="progress-step active">
                <div class="step-circle">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span>Cart</span>
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step">
                <div class="step-circle">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <span>Payment</span>
            </div>
            <div class="progress-connector"></div>
            <div class="progress-step">
                <div class="step-circle">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span>Dispatch</span>
            </div>
        </div>
    </div>

    <!-- =====================================================
         FLASH MESSAGES
    ====================================================== -->
    @if(session('success'))
        <div class="flash-alert flash-success">
            <i class="fa-solid fa-circle-check flash-icon"></i>
            <div class="flash-body">
                <strong>Success!</strong>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="flash-close" onclick="this.closest('.flash-alert').remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-alert flash-error">
            <i class="fa-solid fa-triangle-exclamation flash-icon"></i>
            <div class="flash-body">
                <strong>Error</strong>
                <p>{{ session('error') }}</p>
            </div>
            <button type="button" class="flash-close" onclick="this.closest('.flash-alert').remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- =====================================================
         MAIN CART LAYOUT (2-Column)
    ====================================================== -->
    @if(isset($carts) && $carts->count())
        @php
            $totalPrice = isset($totalPrice) ? $totalPrice : $carts->sum(fn($i) => ($i->medicine->price ?? 0) * $i->quantity);
            $totalQty = $carts->sum('quantity');
            $deliveryFee = 0;
            $grandTotal = $totalPrice + $deliveryFee;
        @endphp

        <div class="cart-layout">

            <!-- LEFT: Cart Items List -->
            <div class="cart-items-panel">
                <div class="items-panel-header">
                    <span class="items-count-pill">{{ $totalQty }} item{{ $totalQty !== 1 ? 's' : '' }}</span>
                    <button type="button" class="clear-all-btn" id="clearAllCartBtn">
                        <i class="fa-solid fa-trash-can"></i> Clear Cart
                    </button>
                </div>

                <div class="cart-items-list" id="cartItemsList">
                    @foreach($carts as $item)
                        @php
                            $price = $item->medicine->price ?? 0;
                            $lineTotal = $price * $item->quantity;
                            $fallback = asset('image/pharma3.png');
                        @endphp

                        <div class="cart-item-row" id="cart-row-{{ $item->id }}" data-cart-id="{{ $item->id }}">

                            <!-- Item Image -->
                            <div class="item-image-box">
                                <img src="{{ optional($item->medicine)->image_url ?? $fallback }}"
                                     alt="{{ $item->medicine->name ?? 'Medicine' }}"
                                     onerror="this.onerror=null; this.src='{{ $fallback }}';">
                            </div>

                            <!-- Item Info -->
                            <div class="item-info">
                                <h3 class="item-name">{{ $item->medicine->name ?? 'Unknown Medicine' }}</h3>
                                <span class="item-type-tag">{{ $item->medicine->type ?? 'General' }}</span>

                                @if($item->medicine && $item->medicine->description)
                                    <p class="item-description">
                                        {{ \Illuminate\Support\Str::limit($item->medicine->description, 70) }}
                                    </p>
                                @endif

                                <div class="item-stock-info">
                                    @php $availableStock = $item->medicine->stock ?? 0; @endphp
                                    @if($availableStock > 0)
                                        <span class="stock-chip available">
                                            <i class="fa-solid fa-circle-check"></i>
                                            {{ $availableStock }} in stock
                                        </span>
                                    @else
                                        <span class="stock-chip low">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                            Low stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="item-qty-col">
                                <label class="qty-label">Quantity</label>
                                <div class="qty-stepper" id="stepper-{{ $item->id }}">
                                    <button type="button"
                                            class="qty-btn minus-btn"
                                            data-cart-id="{{ $item->id }}"
                                            data-current="{{ $item->quantity }}"
                                            data-max="{{ $item->medicine->stock ?? 999 }}"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="number"
                                           class="qty-input-field"
                                           id="qty-{{ $item->id }}"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           max="{{ $item->medicine->stock ?? 999 }}"
                                           readonly>
                                    <button type="button"
                                            class="qty-btn plus-btn"
                                            data-cart-id="{{ $item->id }}"
                                            data-current="{{ $item->quantity }}"
                                            data-max="{{ $item->medicine->stock ?? 999 }}">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Unit Price -->
                            <div class="item-unit-price-col">
                                <span class="unit-label">Unit Price</span>
                                <strong class="unit-price">{{ number_format($price, 0, '.', ' ') }} <small>FCFA</small></strong>
                            </div>

                            <!-- Line Total -->
                            <div class="item-total-col">
                                <span class="total-label">Subtotal</span>
                                <strong class="item-line-total" id="line-total-{{ $item->id }}">
                                    {{ number_format($lineTotal, 0, '.', ' ') }} <small>FCFA</small>
                                </strong>
                            </div>

                            <!-- Remove Button -->
                            <button type="button"
                                    class="remove-item-btn"
                                    data-cart-id="{{ $item->id }}"
                                    title="Remove from cart">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: Order Summary Sidebar -->
            <div class="order-summary-panel">

                <div class="summary-card">
                    <h2 class="summary-title">
                        <i class="fa-solid fa-receipt"></i> Order Summary
                    </h2>

                    <div class="summary-rows">
                        <div class="summary-row">
                            <span>Subtotal (<span id="summaryQty">{{ $totalQty }}</span> item{{ $totalQty !== 1 ? 's' : '' }})</span>
                            <span id="summarySubtotal">{{ number_format($totalPrice, 0, '.', ' ') }} FCFA</span>
                        </div>
                        <div class="summary-row">
                            <span>
                                Delivery Fee
                                <span class="tooltip-badge" title="Medicines are dispensed directly at the hospital pharmacy or delivered to your ward.">
                                    <i class="fa-solid fa-circle-info"></i>
                                </span>
                            </span>
                            <span class="free-delivery">FREE</span>
                        </div>
                        <div class="summary-row">
                            <span>Hospital Discount</span>
                            <span class="discount-value">− 0 FCFA</span>
                        </div>
                    </div>

                    <div class="summary-total-row">
                        <span>Total Amount</span>
                        <strong id="summaryGrandTotal">{{ number_format($grandTotal, 0, '.', ' ') }} FCFA</strong>
                    </div>

                    <!-- Safety & Trust Badges -->
                    <div class="trust-badges">
                        <div class="trust-badge">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Secure &amp; Verified</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fa-solid fa-hospital"></i>
                            <span>Hospital Certified</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fa-solid fa-clock"></i>
                            <span>Quick Dispatch</span>
                        </div>
                    </div>

                    <!-- Checkout CTA -->
                    <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm">
                        @csrf
                        <button type="submit" class="checkout-cta-btn" id="checkoutCta">
                            <i class="fa-solid fa-lock"></i>
                            Place Pharmacy Order
                            <span class="checkout-total-chip" id="checkoutChip">
                                {{ number_format($grandTotal, 0, '.', ' ') }} FCFA
                            </span>
                        </button>
                    </form>

                    <p class="checkout-note">
                        <i class="fa-solid fa-circle-info"></i>
                        By placing this order, you confirm that the medications are prescribed or approved by your attending physician.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="quick-links-card">
                    <a href="/pharmacy" class="quick-link">
                        <i class="fa-solid fa-pills"></i>
                        <span>Add More Medicines</span>
                        <i class="fa-solid fa-arrow-right quick-arrow"></i>
                    </a>
                    <a href="/history" class="quick-link">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>My Order History</span>
                        <i class="fa-solid fa-arrow-right quick-arrow"></i>
                    </a>
                    <a href="/labtests" class="quick-link">
                        <i class="fa-solid fa-flask"></i>
                        <span>Book Lab Tests</span>
                        <i class="fa-solid fa-arrow-right quick-arrow"></i>
                    </a>
                </div>

            </div>
        </div>

    @else
        <!-- =====================================================
             EMPTY CART STATE
        ====================================================== -->
        <div class="empty-cart-container">
            <div class="empty-cart-illustration">
                <div class="empty-cart-icon-outer">
                    <div class="empty-cart-icon-inner">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
            </div>

            <h2 class="empty-cart-title">Your Cart is Empty</h2>
            <p class="empty-cart-desc">
                Browse the hospital pharmacy and add medications or health supplies to your cart.
                Your attending physician's prescription may be required for dispensing.
            </p>

            <div class="empty-cart-actions">
                <a href="/pharmacy" class="btn-browse-pharmacy">
                    <i class="fa-solid fa-pills"></i>
                    Browse Available Medicines
                </a>
                <a href="/labtests" class="btn-browse-labs">
                    <i class="fa-solid fa-flask"></i>
                    Book a Lab Test
                </a>
            </div>

            <div class="empty-feature-list">
                <div class="feature-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Hospital-verified medications</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Fast ward delivery</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-hand-holding-medical"></i>
                    <span>Pharmacist reviewed</span>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Toast Container -->
<div id="toastContainer" class="toast-container-cart" aria-live="polite"></div>

<!-- =====================================================
     CART PAGE STYLES
====================================================== -->
<style>
/* ─── Layout ─────────────────────────── */
.cart-page-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 24px 20px 60px;
    font-family: inherit;
}

/* ─── Page Header ─────────────────────── */
.cart-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 28px;
}

.cart-header-left {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.back-to-shop {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    transition: color 0.18s;
}

.back-to-shop:hover {
    color: #095eff;
}

.cart-page-title {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    line-height: 1.2;
}

.cart-page-subtitle {
    font-size: 13.5px;
    color: #64748b;
    margin: 4px 0 0;
}

/* ─── Checkout Progress Steps ──────────── */
.checkout-progress-steps {
    display: flex;
    align-items: center;
    gap: 4px;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    min-width: 56px;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: #94a3b8;
    transition: all 0.2s;
}

.progress-step.active .step-circle {
    background: #095eff;
    border-color: #095eff;
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(9, 94, 255, 0.3);
}

.progress-step.active {
    color: #095eff;
}

.progress-connector {
    width: 40px;
    height: 2px;
    background: #e2e8f0;
    margin-bottom: 18px;
    border-radius: 2px;
}

/* ─── Flash Messages ────────────────────── */
.flash-alert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    position: relative;
}

.flash-success {
    background: #f0fdf4;
    border: 1.5px solid #bbf7d0;
}

.flash-error {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
}

.flash-icon {
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.flash-success .flash-icon { color: #16a34a; }
.flash-error .flash-icon   { color: #dc2626; }

.flash-body strong {
    font-size: 14px;
    color: #0f172a;
    display: block;
    margin-bottom: 2px;
}

.flash-body p {
    font-size: 13px;
    margin: 0;
    color: #334155;
}

.flash-close {
    position: absolute;
    top: 12px;
    right: 14px;
    background: none;
    border: none;
    color: #94a3b8;
    font-size: 14px;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
}

.flash-close:hover { color: #475569; background: rgba(0,0,0,0.04); }

/* ─── 2-Column Layout ─────────────────── */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 24px;
    align-items: start;
}

/* ─── Items Panel ─────────────────────── */
.cart-items-panel {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
}

.items-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    border-bottom: 1.5px solid #f1f5f9;
    background: #fafcff;
}

.items-count-pill {
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 99px;
}

.clear-all-btn {
    background: none;
    border: 1.5px solid #fecaca;
    color: #dc2626;
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 14px;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.18s;
}

.clear-all-btn:hover {
    background: #fef2f2;
}

/* ─── Cart Item Row ───────────────────── */
.cart-items-list {
    display: flex;
    flex-direction: column;
}

.cart-item-row {
    display: grid;
    grid-template-columns: 80px 1fr 130px 110px 120px 40px;
    gap: 16px;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1.5px solid #f8fafc;
    transition: background 0.15s;
}

.cart-item-row:last-child {
    border-bottom: none;
}

.cart-item-row:hover {
    background: #fafcff;
}

.cart-item-row.removing {
    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.3s, transform 0.3s;
}

/* Image */
.item-image-box {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    flex-shrink: 0;
}

.item-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Item Info */
.item-info { display: flex; flex-direction: column; gap: 4px; min-width: 0; }

.item-name {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-type-tag {
    display: inline-block;
    font-size: 10.5px;
    font-weight: 700;
    color: #1d4ed8;
    background: #eff6ff;
    padding: 2px 8px;
    border-radius: 5px;
    width: fit-content;
}

.item-description {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

.stock-chip {
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 8px;
    border-radius: 5px;
    width: fit-content;
}

.stock-chip.available { background: #f0fdf4; color: #16a34a; }
.stock-chip.low { background: #fffbeb; color: #b45309; }

/* Qty Stepper */
.item-qty-col { display: flex; flex-direction: column; align-items: center; gap: 6px; }

.qty-label {
    font-size: 10.5px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.qty-stepper {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    height: 36px;
    transition: border-color 0.2s;
}

.qty-stepper:focus-within {
    border-color: #095eff;
    box-shadow: 0 0 0 3px rgba(9, 94, 255, 0.10);
}

.qty-btn {
    background: none;
    border: none;
    width: 30px;
    height: 100%;
    color: #64748b;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}

.qty-btn:hover:not(:disabled) {
    background: #eff6ff;
    color: #095eff;
}

.qty-btn:disabled {
    color: #cbd5e1;
    cursor: not-allowed;
}

.qty-btn.loading {
    opacity: 0.5;
    pointer-events: none;
}

.qty-input-field {
    width: 34px;
    border: none;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    background: transparent;
    outline: none;
    -moz-appearance: textfield;
}

.qty-input-field::-webkit-outer-spin-button,
.qty-input-field::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

/* Prices */
.item-unit-price-col, .item-total-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-align: center;
}

.unit-label, .total-label {
    font-size: 10.5px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
}

.unit-price, .item-line-total {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}

.item-line-total {
    color: #059669;
    font-size: 15.5px;
}

.unit-price small, .item-line-total small {
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
}

/* Remove Button */
.remove-item-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1.5px solid #fecaca;
    background: #fff;
    color: #dc2626;
    font-size: 13px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.18s;
    flex-shrink: 0;
}

.remove-item-btn:hover {
    background: #fef2f2;
    border-color: #f87171;
}

/* ─── Order Summary Panel ─────────────── */
.order-summary-panel {
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: sticky;
    top: 20px;
}

.summary-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    overflow: hidden;
}

.summary-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16.5px;
    font-weight: 800;
    color: #0f172a;
    padding: 20px 22px 16px;
    border-bottom: 1.5px solid #f1f5f9;
    margin: 0;
    background: #fafcff;
}

.summary-title i { color: #095eff; }

.summary-rows {
    padding: 16px 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    border-bottom: 1.5px dashed #e2e8f0;
    margin-bottom: 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13.5px;
    color: #475569;
}

.free-delivery {
    font-size: 12.5px;
    font-weight: 800;
    color: #16a34a;
    background: #f0fdf4;
    padding: 3px 10px;
    border-radius: 6px;
}

.discount-value { color: #16a34a; font-weight: 600; }

.tooltip-badge {
    color: #94a3b8;
    font-size: 12px;
    cursor: help;
    margin-left: 4px;
}

.summary-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    background: #f8faff;
    border-top: 1.5px solid #e2e8f0;
    border-bottom: 1.5px solid #e2e8f0;
}

.summary-total-row strong {
    font-size: 20px;
    font-weight: 900;
    color: #059669;
    letter-spacing: -0.5px;
}

/* Trust Badges */
.trust-badges {
    display: flex;
    justify-content: space-around;
    padding: 14px 18px;
    border-bottom: 1.5px solid #f1f5f9;
}

.trust-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    text-align: center;
}

.trust-badge i {
    font-size: 18px;
    color: #095eff;
}

/* Checkout CTA */
.checkout-cta-btn {
    width: 100%;
    padding: 16px 20px;
    background: linear-gradient(135deg, #095eff 0%, #1e40af 100%);
    color: #ffffff;
    border: none;
    font-size: 15px;
    font-weight: 800;
    border-radius: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.22s;
    letter-spacing: 0.2px;
}

.checkout-cta-btn:hover {
    background: linear-gradient(135deg, #0043d9 0%, #1d3eb0 100%);
    box-shadow: 0 6px 20px rgba(9, 94, 255, 0.28);
    transform: translateY(-1px);
}

.checkout-total-chip {
    font-size: 13px;
    background: rgba(255, 255, 255, 0.2);
    padding: 3px 10px;
    border-radius: 6px;
    font-weight: 700;
}

.checkout-note {
    font-size: 11.5px;
    color: #64748b;
    text-align: center;
    padding: 14px 18px;
    margin: 0;
    line-height: 1.5;
    display: flex;
    align-items: flex-start;
    gap: 7px;
}

.checkout-note i { color: #94a3b8; font-size: 13px; margin-top: 1px; flex-shrink: 0; }

/* Quick Links Card */
.quick-links-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    text-decoration: none;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.15s;
}

.quick-link:last-child { border-bottom: none; }

.quick-link i:first-child {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: #eff6ff;
    color: #095eff;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-link:hover {
    background: #f8faff;
    color: #095eff;
}

.quick-arrow {
    margin-left: auto;
    font-size: 11px;
    color: #94a3b8;
    transition: transform 0.15s;
}

.quick-link:hover .quick-arrow {
    transform: translateX(3px);
    color: #095eff;
}

/* ─── Empty Cart State ───────────────── */
.empty-cart-container {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 22px;
    padding: 64px 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
}

.empty-cart-icon-outer {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
}

.empty-cart-icon-inner {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #095eff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    color: #ffffff;
    box-shadow: 0 8px 24px rgba(9, 94, 255, 0.3);
}

.empty-cart-title {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 10px;
}

.empty-cart-desc {
    font-size: 14px;
    color: #64748b;
    max-width: 440px;
    line-height: 1.6;
    margin: 0 0 28px;
}

.empty-cart-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 36px;
}

.btn-browse-pharmacy {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #095eff;
    color: #ffffff;
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(9, 94, 255, 0.25);
    transition: all 0.2s;
}

.btn-browse-pharmacy:hover {
    background: #0043d9;
    transform: translateY(-2px);
}

.btn-browse-labs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    color: #475569;
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    border: 1.5px solid #e2e8f0;
    transition: all 0.2s;
}

.btn-browse-labs:hover {
    border-color: #095eff;
    color: #095eff;
    background: #f8faff;
}

.empty-feature-list {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    justify-content: center;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
}

.feature-item i { color: #095eff; }

/* ─── Toast ─────────────────────────── */
.toast-container-cart {
    position: fixed;
    bottom: 24px;
    right: 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 9999;
    pointer-events: none;
}

.cart-toast {
    pointer-events: auto;
    background: #0f172a;
    color: #ffffff;
    border-radius: 12px;
    padding: 14px 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 280px;
    max-width: 380px;
    font-size: 13.5px;
    animation: toastIn 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    transition: opacity 0.3s, transform 0.3s;
}

.cart-toast.success { border-left: 4px solid #10b981; }
.cart-toast.error   { border-left: 4px solid #ef4444; }

.cart-toast.success i { color: #10b981; font-size: 18px; }
.cart-toast.error   i { color: #ef4444; font-size: 18px; }

@keyframes toastIn {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ─── Responsive ─────────────────────── */
@media (max-width: 1060px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
    .order-summary-panel {
        position: static;
    }
    .cart-item-row {
        grid-template-columns: 72px 1fr 110px;
        grid-template-rows: auto auto auto;
        gap: 10px 12px;
    }
    .item-image-box { grid-row: 1 / 3; width: 72px; height: 72px; }
    .item-info { grid-column: 2 / 4; }
    .item-qty-col { grid-column: 2; align-items: flex-start; }
    .item-unit-price-col { display: none; }
    .item-total-col { grid-column: 3; align-items: flex-end; }
    .remove-item-btn { grid-column: 4; grid-row: 1; }
}

@media (max-width: 680px) {
    .cart-page-header { flex-direction: column; }
    .checkout-progress-steps { display: none; }
    .cart-item-row { padding: 16px; }
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const toast = document.getElementById('toastContainer');
    const sidebarBadge = document.getElementById('sidebarCartBadge');

    /* ── Toast Notification ───────────── */
    function showToast(message, type = 'success') {
        const el = document.createElement('div');
        el.className = `cart-toast ${type}`;
        el.innerHTML = `
            <i class="fa-solid fa-${type === 'success' ? 'circle-check' : 'triangle-exclamation'}"></i>
            <span>${message}</span>
        `;
        toast.appendChild(el);
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
            setTimeout(() => el.remove(), 300);
        }, 3500);
    }

    /* ── Update global badge counts ──── */
    function syncBadges(count) {
        if (sidebarBadge) {
            sidebarBadge.textContent = count;
            sidebarBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    /* ── Update Summary Totals in DOM ── */
    function updateSummaryUI(data) {
        if (data.totalAmount !== undefined) {
            const subtotalEl = document.getElementById('summarySubtotal');
            const grandEl    = document.getElementById('summaryGrandTotal');
            const chipEl     = document.getElementById('checkoutChip');
            const qtyEl      = document.getElementById('summaryQty');

            if (subtotalEl) subtotalEl.textContent = data.totalAmount;
            if (grandEl)    grandEl.textContent    = data.totalAmount;
            if (chipEl)     chipEl.textContent      = data.totalAmount;
            if (qtyEl)      qtyEl.textContent       = data.totalQty ?? '';
        }
    }

    /* ── AJAX: Update Item Quantity ─── */
    async function updateQty(cartId, newQty) {
        try {
            const formData = new FormData();
            formData.append('_token', CSRF);
            formData.append('_method', 'PUT');
            formData.append('quantity', newQty);

            const res = await fetch(`/cart/${cartId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: formData
            });

            const data = await res.json();

            if (res.ok && data.success) {
                // Update line total
                const lineTotalEl = document.getElementById(`line-total-${cartId}`);
                if (lineTotalEl && data.lineTotal) {
                    lineTotalEl.innerHTML = `${data.lineTotal} <small>FCFA</small>`;
                }
                // Sync summary panel
                updateSummaryUI(data);
                syncBadges(data.cartCount ?? 0);
            } else {
                throw new Error(data.message || 'Could not update quantity.');
            }
        } catch (err) {
            showToast(err.message, 'error');
        }
    }

    /* ── AJAX: Remove Item ───────────── */
    async function removeItem(cartId) {
        const row = document.getElementById(`cart-row-${cartId}`);
        if (row) {
            row.classList.add('removing');
            await new Promise(r => setTimeout(r, 300));
        }

        try {
            const formData = new FormData();
            formData.append('_token', CSRF);
            formData.append('_method', 'DELETE');

            const res = await fetch(`/cart/${cartId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF
                },
                body: formData
            });

            const data = await res.json();

            if (res.ok && data.success) {
                if (row) row.remove();
                showToast('Item removed from cart.', 'success');
                updateSummaryUI(data);
                syncBadges(data.cartCount ?? 0);

                // If cart is now empty, reload to show empty state
                if (data.isEmpty) {
                    setTimeout(() => window.location.reload(), 800);
                }
            } else {
                throw new Error(data.message || 'Could not remove item.');
            }
        } catch (err) {
            if (row) row.classList.remove('removing');
            showToast(err.message, 'error');
        }
    }

    /* ── Qty Stepper Minus ─────────── */
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const cartId  = this.dataset.cartId;
            const input   = document.getElementById(`qty-${cartId}`);
            const current = parseInt(input.value) || 1;
            const newQty  = Math.max(1, current - 1);
            if (newQty === current) return;

            input.value = newQty;
            const plusBtn = this.closest('.qty-stepper').querySelector('.plus-btn');
            this.disabled = newQty <= 1;
            if (plusBtn) plusBtn.disabled = false;

            updateQty(cartId, newQty);
        });
    });

    /* ── Qty Stepper Plus ──────────── */
    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const cartId  = this.dataset.cartId;
            const input   = document.getElementById(`qty-${cartId}`);
            const max     = parseInt(this.dataset.max) || 999;
            const current = parseInt(input.value) || 1;
            const newQty  = Math.min(max, current + 1);
            if (newQty === current) {
                showToast(`Maximum available quantity reached (${max} units).`, 'error');
                return;
            }

            input.value = newQty;
            const minusBtn = this.closest('.qty-stepper').querySelector('.minus-btn');
            this.disabled = newQty >= max;
            if (minusBtn) minusBtn.disabled = false;

            updateQty(cartId, newQty);
        });
    });

    /* ── Remove Item Buttons ─────────── */
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            removeItem(this.dataset.cartId);
        });
    });

    /* ── Clear All Cart ──────────────── */
    document.getElementById('clearAllCartBtn')?.addEventListener('click', async function () {
        if (!confirm('Are you sure you want to remove all items from your cart?')) return;

        const rows = document.querySelectorAll('.cart-item-row');
        for (const row of rows) {
            const cartId = row.dataset.cartId;
            if (cartId) {
                row.classList.add('removing');
                await new Promise(r => setTimeout(r, 100));
                try {
                    const fd = new FormData();
                    fd.append('_token', CSRF);
                    fd.append('_method', 'DELETE');
                    await fetch(`/cart/${cartId}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF
                        },
                        body: fd
                    });
                } catch (e) {}
            }
        }
        setTimeout(() => window.location.reload(), 500);
    });
});
</script>
@endsection