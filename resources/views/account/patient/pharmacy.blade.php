@extends('layout.index')
@section('content')

<div class="pharmacy-page-container">

    <!-- =====================================================
         PHARMACY HERO & PAGE HEADER
    ====================================================== -->
    <div class="pharmacy-hero-card">
        <div class="hero-content">
            <div class="hero-tag">
                <i class="fa-solid fa-shield-halved"></i> Verified Hospital Pharmacy & Prescriptions
            </div>
            <h1 class="hero-title">Available Medicines & Health Essentials</h1>
            <p class="hero-subtitle">
                Browse hospital-grade medications, analgesics, antibiotics, and medical supplies. Add items to your cart for direct pickup or bedside dispatch.
            </p>
        </div>

        <div class="hero-cart-widget">
            <a href="/cart" class="hero-cart-btn" id="heroCartBtn">
                <div class="cart-icon-wrap">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="widget-cart-badge" id="topCartBadge" style="{{ ($cartCount ?? 0) > 0 ? '' : 'display:none;' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </div>
                <div class="cart-btn-text">
                    <span class="cart-label">My Cart</span>
                    <strong class="cart-subtext" id="topCartSubtext">
                        {{ ($cartCount ?? 0) > 0 ? ($cartCount . ' item' . ($cartCount > 1 ? 's' : '')) : '0 items' }}
                    </strong>
                </div>
                <i class="fa-solid fa-arrow-right arrow-icon"></i>
            </a>
        </div>
    </div>

    <!-- =====================================================
         SEARCH & CATEGORY FILTER TOOLBAR
    ====================================================== -->
    <div class="pharmacy-toolbar">
        
        <!-- Search Input -->
        <div class="search-box-wrapper">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="pharmacySearch" placeholder="Search medicines by name, category, or indication..." autocomplete="off">
            <button type="button" id="clearSearchBtn" class="clear-search-btn" style="display:none;" title="Clear search">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- In-Stock Filter Toggle & Sort -->
        <div class="toolbar-controls">
            <label class="stock-toggle-label">
                <input type="checkbox" id="inStockToggle">
                <span class="toggle-switch"></span>
                <span class="toggle-text">In-Stock Only</span>
            </label>

            <div class="sort-select-wrapper">
                <i class="fa-solid fa-arrow-down-wide-short sort-icon"></i>
                <select id="pharmacySort">
                    <option value="featured">Featured / Default</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="name-asc">Name: A to Z</option>
                    <option value="stock-desc">Highest Stock</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Category Filter Pills -->
    <div class="category-pills-bar" id="categoryPills">
        <button type="button" class="category-pill active" data-category="all">
            <i class="fa-solid fa-border-all"></i> All Medicines
            <span class="pill-count">{{ $medicines->count() }}</span>
        </button>

        @php
            $knownCategories = ['Tablets', 'Capsules', 'Syrup', 'Injection', 'Powder', 'Cotton', 'Band', 'Drips'];
            $existingCategories = $medicines->pluck('type')->unique()->filter()->values();
        @endphp

        @foreach($existingCategories as $cat)
            @php
                $catCount = $medicines->where('type', $cat)->count();
                $catIcon = 'fa-pills';
                if(in_array($cat, ['Capsules'])) $catIcon = 'fa-capsules';
                elseif(in_array($cat, ['Syrup'])) $catIcon = 'fa-prescription-bottle-medical';
                elseif(in_array($cat, ['Injection', 'Drips'])) $catIcon = 'fa-syringe';
                elseif(in_array($cat, ['Cotton', 'Band'])) $catIcon = 'fa-bandage';
            @endphp
            <button type="button" class="category-pill" data-category="{{ strtolower($cat) }}">
                <i class="fa-solid {{ $catIcon }}"></i> {{ $cat }}
                <span class="pill-count">{{ $catCount }}</span>
            </button>
        @endforeach
    </div>

    <!-- Live Results Summary Bar -->
    <div class="results-meta-bar">
        <span id="resultsCountText">Showing <strong>{{ $medicines->count() }}</strong> available medicines</span>
        <span class="safety-note"><i class="fa-solid fa-circle-info"></i> All medicines are verified & inspected by the hospital dispensary</span>
    </div>

    <!-- =====================================================
         MEDICINES PRODUCT CARDS GRID
    ====================================================== -->
    <div class="medicines-grid" id="medicineGrid">
        @forelse($medicines as $medicine)
            @php
                $isOutOfStock = $medicine->stock <= 0;
                $isLowStock = $medicine->stock > 0 && $medicine->stock <= 5;
                $fallbackImage = asset('image/pharma3.png');
                if (in_array($medicine->type, ['Cotton', 'Band'])) {
                    $fallbackImage = asset('image/med.png');
                } elseif (in_array($medicine->type, ['Injection'])) {
                    $fallbackImage = asset('image/pharma.png');
                }
            @endphp

            <div class="medicine-card"
                 data-id="{{ $medicine->id }}"
                 data-name="{{ strtolower($medicine->name) }}"
                 data-category="{{ strtolower($medicine->type ?? 'general') }}"
                 data-price="{{ (float)$medicine->price }}"
                 data-stock="{{ (int)$medicine->stock }}"
                 data-description="{{ strtolower($medicine->description ?? '') }}">

                <!-- Card Header: Image & Badges -->
                <div class="card-image-wrap">
                    <img src="{{ $medicine->image_url ?? $fallbackImage }}"
                         alt="{{ $medicine->name }}"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ $fallbackImage }}';">

                    <!-- Category Type Badge -->
                    <span class="card-badge-type">
                        {{ $medicine->type ?? 'Medicine' }}
                    </span>

                    <!-- Stock Status Badge -->
                    @if($isOutOfStock)
                        <span class="card-badge-stock out-of-stock">
                            <i class="fa-solid fa-circle-xmark"></i> Out of Stock
                        </span>
                    @elseif($isLowStock)
                        <span class="card-badge-stock low-stock">
                            <i class="fa-solid fa-triangle-exclamation"></i> Only {{ $medicine->stock }} left
                        </span>
                    @else
                        <span class="card-badge-stock in-stock">
                            <i class="fa-solid fa-circle-check"></i> In Stock
                        </span>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <h3 class="medicine-name" title="{{ $medicine->name }}">{{ $medicine->name }}</h3>

                    @if($medicine->description)
                        <p class="medicine-desc" title="{{ $medicine->description }}">
                            {{ $medicine->description }}
                        </p>
                    @else
                        <p class="medicine-desc text-muted">
                            Standard clinical medication. Follow medical practitioner guidance.
                        </p>
                    @endif

                    <div class="medicine-details-row">
                        @if($medicine->expiry_date)
                            <span class="detail-item" title="Expiry date">
                                <i class="fa-regular fa-calendar-check"></i> Exp: {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('M Y') }}
                            </span>
                        @endif

                        <span class="detail-item stock-info">
                            <i class="fa-solid fa-boxes-stacked"></i> {{ $medicine->stock }} units
                        </span>
                    </div>
                </div>

                <!-- Card Footer: Pricing & Add to Cart -->
                <div class="card-footer">
                    <div class="price-container">
                        <span class="price-label">Price</span>
                        <strong class="price-amount">{{ number_format($medicine->price, 0, '.', ' ') }} <small>FCFA</small></strong>
                    </div>

                    <div class="card-actions">
                        @if(!$isOutOfStock)
                            <!-- Quantity Stepper Controls -->
                            <div class="qty-stepper">
                                <button type="button" class="qty-btn minus" title="Decrease quantity">−</button>
                                <input type="number" class="qty-input" value="1" min="1" max="{{ $medicine->stock }}" readonly>
                                <button type="button" class="qty-btn plus" title="Increase quantity">+</button>
                            </div>

                            <!-- Add to Cart Trigger Button -->
                            <button type="button" class="btn-add-cart" data-id="{{ $medicine->id }}" title="Add to your cart">
                                <i class="fa-solid fa-cart-plus btn-icon"></i>
                                <span class="btn-text">Add</span>
                            </button>
                        @else
                            <button type="button" class="btn-out-of-stock" disabled>
                                <i class="fa-solid fa-ban"></i> Unavailable
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="empty-catalog-box">
                <div class="empty-icon-wrap">
                    <i class="fa-solid fa-pills"></i>
                </div>
                <h3>No Medicines Listed</h3>
                <p>There are currently no active medicines in the pharmacy catalog. Please check back shortly.</p>
            </div>
        @endforelse
    </div>

    <!-- No Search Results Fallback State -->
    <div id="noSearchResults" class="empty-catalog-box" style="display:none;">
        <div class="empty-icon-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <h3>No Matching Medicines Found</h3>
        <p>We couldn't find any medications matching your current search or filters.</p>
        <button type="button" id="resetFiltersBtn" class="reset-filters-btn">
            <i class="fa-solid fa-rotate-left"></i> Reset All Filters
        </button>
    </div>

</div>

<!-- =====================================================
     FLOATING TOAST NOTIFICATION CONTAINER
====================================================== -->
<div id="toastContainer" class="toast-container" aria-live="polite"></div>

<!-- =====================================================
     SCOPED PHARMACY PRESENTATION STYLES
====================================================== -->
<style>
/* Page Layout */
.pharmacy-page-container {
    max-width: 1320px;
    margin: 0 auto;
    padding: 24px 20px 60px 20px;
    font-family: inherit;
}

/* Hero Section */
.pharmacy-hero-card {
    background: linear-gradient(135deg, #095eff 0%, #1e40af 100%);
    border-radius: 18px;
    padding: 30px 36px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    box-shadow: 0 10px 30px rgba(9, 94, 255, 0.18);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.pharmacy-hero-card::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
    pointer-events: none;
}

.hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(8px);
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.hero-title {
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 8px 0;
    color: #ffffff;
    line-height: 1.25;
}

.hero-subtitle {
    font-size: 14.5px;
    color: #e0e7ff;
    margin: 0;
    max-width: 640px;
    line-height: 1.5;
}

.hero-cart-widget {
    flex-shrink: 0;
}

.hero-cart-btn {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
    color: #0f172a;
    padding: 14px 22px;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.hero-cart-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.22);
    color: #095eff;
}

.cart-icon-wrap {
    position: relative;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #eff6ff;
    color: #095eff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.widget-cart-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #ef4444;
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    min-width: 20px;
    height: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 5px;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.cart-btn-text {
    display: flex;
    flex-direction: column;
}

.cart-label {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
}

.cart-subtext {
    font-size: 14px;
    color: #0f172a;
    font-weight: 700;
}

.arrow-icon {
    font-size: 13px;
    color: #94a3b8;
    transition: transform 0.2s;
}

.hero-cart-btn:hover .arrow-icon {
    transform: translateX(4px);
    color: #095eff;
}

/* Toolbar & Filters */
.pharmacy-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 16px;
}

.search-box-wrapper {
    position: relative;
    flex: 1;
    min-width: 280px;
    max-width: 540px;
}

.search-box-wrapper input {
    width: 100%;
    padding: 13px 40px 13px 44px;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    font-size: 14.5px;
    color: #1e293b;
    background: #ffffff;
    outline: none;
    transition: all 0.2s;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
}

.search-box-wrapper input:focus {
    border-color: #095eff;
    box-shadow: 0 0 0 3.5px rgba(9, 94, 255, 0.12);
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
    pointer-events: none;
}

.clear-search-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: #f1f5f9;
    border: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    color: #64748b;
    font-size: 11px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.clear-search-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.toolbar-controls {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.stock-toggle-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    padding: 9px 14px;
    border-radius: 10px;
    user-select: none;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s;
}

.stock-toggle-label:hover {
    border-color: #94a3b8;
}

.stock-toggle-label input {
    display: none;
}

.toggle-switch {
    width: 34px;
    height: 18px;
    background: #cbd5e1;
    border-radius: 99px;
    position: relative;
    transition: background 0.2s;
}

.toggle-switch::after {
    content: '';
    position: absolute;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #ffffff;
    top: 2px;
    left: 2px;
    transition: transform 0.2s;
}

.stock-toggle-label input:checked + .toggle-switch {
    background: #059669;
}

.stock-toggle-label input:checked + .toggle-switch::after {
    transform: translateX(16px);
}

.sort-select-wrapper {
    position: relative;
}

.sort-select-wrapper select {
    appearance: none;
    padding: 11px 36px 11px 36px;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    background: #ffffff;
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    outline: none;
    cursor: pointer;
}

.sort-select-wrapper select:focus {
    border-color: #095eff;
}

.sort-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 13px;
    pointer-events: none;
}

/* Category Pills */
.category-pills-bar {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 8px;
    margin-bottom: 18px;
    scrollbar-width: thin;
}

.category-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 99px;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
}

.category-pill:hover {
    border-color: #095eff;
    color: #095eff;
    background: #f8faff;
}

.category-pill.active {
    background: #095eff;
    border-color: #095eff;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(9, 94, 255, 0.25);
}

.pill-count {
    font-size: 11px;
    background: rgba(0, 0, 0, 0.06);
    padding: 2px 7px;
    border-radius: 99px;
    font-weight: 700;
}

.category-pill.active .pill-count {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

/* Meta Bar */
.results-meta-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 8px;
}

.safety-note {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #059669;
    font-weight: 500;
}

/* Medicines Cards Grid */
.medicines-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 22px;
}

/* Medicine Card */
.medicine-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.medicine-card:hover {
    transform: translateY(-4px);
    border-color: #bfdbfe;
    box-shadow: 0 12px 28px rgba(9, 94, 255, 0.08);
}

.card-image-wrap {
    position: relative;
    width: 100%;
    height: 180px;
    background: #f8fafc;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}

.medicine-card:hover .card-image-wrap img {
    transform: scale(1.06);
}

.card-badge-type {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(6px);
    color: #1e40af;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid rgba(219, 234, 254, 0.8);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.card-badge-stock {
    position: absolute;
    top: 12px;
    right: 12px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.card-badge-stock.in-stock {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.card-badge-stock.low-stock {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}

.card-badge-stock.out-of-stock {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Card Body */
.card-body {
    padding: 16px 18px 12px 18px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.medicine-name {
    font-size: 16.5px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 6px 0;
    line-height: 1.35;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.medicine-desc {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 12px 0;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
}

.medicine-details-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11.5px;
    color: #64748b;
    border-top: 1px dashed #e2e8f0;
    padding-top: 10px;
    margin-top: auto;
}

.detail-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.detail-item i {
    color: #94a3b8;
}

/* Card Footer */
.card-footer {
    padding: 12px 18px 16px 18px;
    background: #fafcff;
    border-top: 1.5px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.price-container {
    display: flex;
    flex-direction: column;
}

.price-label {
    font-size: 10.5px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
}

.price-amount {
    font-size: 16.5px;
    font-weight: 800;
    color: #059669;
    letter-spacing: -0.2px;
}

.price-amount small {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
}

.card-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty-stepper {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    overflow: hidden;
    height: 34px;
}

.qty-btn {
    background: none;
    border: none;
    width: 26px;
    height: 100%;
    color: #475569;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
}

.qty-btn:hover {
    background: #f1f5f9;
    color: #095eff;
}

.qty-input {
    width: 28px;
    border: none;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    outline: none;
    background: transparent;
    padding: 0;
    -moz-appearance: textfield;
}

.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.btn-add-cart {
    background: #095eff;
    color: #ffffff;
    border: none;
    padding: 0 14px;
    height: 34px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 3px 10px rgba(9, 94, 255, 0.25);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-add-cart:hover {
    background: #004bd6;
    transform: scale(1.03);
    box-shadow: 0 5px 14px rgba(9, 94, 255, 0.35);
}

.btn-add-cart.added {
    background: #10b981 !important;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3) !important;
}

.btn-out-of-stock {
    background: #f1f5f9;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: not-allowed;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Empty State */
.empty-catalog-box {
    grid-column: 1 / -1;
    background: #ffffff;
    border: 2px dashed #cbd5e1;
    border-radius: 18px;
    padding: 50px 24px;
    text-align: center;
    color: #64748b;
    margin-top: 10px;
}

.empty-icon-wrap {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: #eff6ff;
    color: #095eff;
    font-size: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px auto;
}

.empty-catalog-box h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 8px 0;
}

.reset-filters-btn {
    background: #095eff;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13.5px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 14px;
}

/* Floating Toast Notifications */
.toast-container {
    position: fixed;
    bottom: 24px;
    right: 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 9999;
    pointer-events: none;
}

.toast-message {
    pointer-events: auto;
    background: #0f172a;
    color: #ffffff;
    border-radius: 12px;
    padding: 14px 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 320px;
    max-width: 420px;
    animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    transition: opacity 0.3s, transform 0.3s;
}

.toast-message.success {
    border-left: 4px solid #10b981;
}

.toast-message.error {
    border-left: 4px solid #ef4444;
}

.toast-icon {
    font-size: 20px;
    flex-shrink: 0;
}

.toast-message.success .toast-icon {
    color: #10b981;
}

.toast-message.error .toast-icon {
    color: #ef4444;
}

.toast-text {
    flex: 1;
    font-size: 13.5px;
    line-height: 1.4;
}

.toast-link {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 10px;
    border-radius: 6px;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s;
}

.toast-link:hover {
    background: rgba(255, 255, 255, 0.28);
}

@keyframes toastSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Responsive Breakpoints */
@media (max-width: 860px) {
    .pharmacy-hero-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 24px;
    }
    .hero-cart-widget {
        width: 100%;
    }
    .hero-cart-btn {
        width: 100%;
        justify-content: space-between;
    }
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const searchInput = document.getElementById('pharmacySearch');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const inStockToggle = document.getElementById('inStockToggle');
    const sortSelect = document.getElementById('pharmacySort');
    const categoryPills = document.querySelectorAll('.category-pill');
    const cards = Array.from(document.querySelectorAll('.medicine-card'));
    const grid = document.getElementById('medicineGrid');
    const noResults = document.getElementById('noSearchResults');
    const resultsCountText = document.getElementById('resultsCountText');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');
    const toastContainer = document.getElementById('toastContainer');
    const topCartBadge = document.getElementById('topCartBadge');
    const topCartSubtext = document.getElementById('topCartSubtext');
    const sidebarCartBadge = document.getElementById('sidebarCartBadge');

    let activeCategory = 'all';

    // Toast Notification Dispatcher
    function showToast(message, type = 'success', showCartLink = true) {
        const toast = document.createElement('div');
        toast.className = `toast-message ${type}`;
        toast.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'} toast-icon"></i>
            <div class="toast-text">${message}</div>
            ${showCartLink ? '<a href="/cart" class="toast-link">View Cart →</a>' : ''}
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Update Live Badges
    function updateCartBadges(count) {
        if (topCartBadge) {
            topCartBadge.textContent = count;
            topCartBadge.style.display = count > 0 ? 'flex' : 'none';
        }
        if (topCartSubtext) {
            topCartSubtext.textContent = count > 0 ? (count + ' item' + (count > 1 ? 's' : '')) : '0 items';
        }
        if (sidebarCartBadge) {
            sidebarCartBadge.textContent = count;
            sidebarCartBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    // Quantity Steppers
    document.querySelectorAll('.qty-stepper').forEach(stepper => {
        const minusBtn = stepper.querySelector('.minus');
        const plusBtn = stepper.querySelector('.plus');
        const input = stepper.querySelector('.qty-input');
        const max = parseInt(input.getAttribute('max')) || 999;

        minusBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            let current = parseInt(input.value) || 1;
            if (current > 1) {
                input.value = current - 1;
            }
        });

        plusBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            let current = parseInt(input.value) || 1;
            if (current < max) {
                input.value = current + 1;
            } else {
                showToast(`Maximum available quantity reached (${max})`, 'error', false);
            }
        });
    });

    // Add To Cart Handler (AJAX)
    document.querySelectorAll('.btn-add-cart').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const medId = this.dataset.id;
            const card = this.closest('.medicine-card');
            const qtyInput = card ? card.querySelector('.qty-input') : null;
            const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

            const originalHtml = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            try {
                const response = await fetch('/cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        medicine_id: medId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.classList.add('added');
                    this.innerHTML = '<i class="fa-solid fa-check"></i> Added';
                    updateCartBadges(data.cartCount);
                    showToast(data.message || 'Added to cart!', 'success', true);

                    // Reset button after 1.8s
                    setTimeout(() => {
                        this.classList.remove('added');
                        this.innerHTML = originalHtml;
                        this.disabled = false;
                        if (qtyInput) qtyInput.value = 1;
                    }, 1800);
                } else {
                    throw new Error(data.message || 'Could not add medicine to cart.');
                }
            } catch (err) {
                this.innerHTML = originalHtml;
                this.disabled = false;
                showToast(err.message || 'Error adding item to cart. Please try again.', 'error', false);
            }
        });
    });

    // Filter & Sorting Logic
    function filterAndSortCards() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const inStockOnly = inStockToggle ? inStockToggle.checked : false;
        const sortBy = sortSelect ? sortSelect.value : 'featured';

        // Toggle clear search cross icon
        if (clearSearchBtn) {
            clearSearchBtn.style.display = query ? 'flex' : 'none';
        }

        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name || '';
            const category = card.dataset.category || '';
            const desc = card.dataset.description || '';
            const stock = parseInt(card.dataset.stock) || 0;

            const matchesSearch = !query || name.includes(query) || desc.includes(query) || category.includes(query);
            const matchesCategory = activeCategory === 'all' || category === activeCategory;
            const matchesStock = !inStockOnly || stock > 0;

            if (matchesSearch && matchesCategory && matchesStock) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Sorting
        const visibleCards = cards.filter(c => c.style.display !== 'none');
        visibleCards.sort((a, b) => {
            if (sortBy === 'price-asc') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if (sortBy === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            if (sortBy === 'name-asc') return a.dataset.name.localeCompare(b.dataset.name);
            if (sortBy === 'stock-desc') return parseInt(b.dataset.stock) - parseInt(a.dataset.stock);
            return parseInt(a.dataset.id) - parseInt(b.dataset.id);
        });

        visibleCards.forEach(c => grid.appendChild(c));

        // Update counts & empty state
        if (resultsCountText) {
            resultsCountText.innerHTML = `Showing <strong>${visibleCount}</strong> medicine${visibleCount !== 1 ? 's' : ''}`;
        }

        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Category Pill Click
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function () {
            categoryPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.dataset.category || 'all';
            filterAndSortCards();
        });
    });

    // Search events
    searchInput?.addEventListener('input', filterAndSortCards);
    inStockToggle?.addEventListener('change', filterAndSortCards);
    sortSelect?.addEventListener('change', filterAndSortCards);

    clearSearchBtn?.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        filterAndSortCards();
        searchInput?.focus();
    });

    resetFiltersBtn?.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (inStockToggle) inStockToggle.checked = false;
        if (sortSelect) sortSelect.value = 'featured';
        activeCategory = 'all';
        categoryPills.forEach(p => p.classList.toggle('active', p.dataset.category === 'all'));
        filterAndSortCards();
    });
});
</script>
@endsection
