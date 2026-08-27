@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 50px;">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;margin-bottom:20px;">
        <div>
            <h1 class="page-title">Pharmacy & Medicine Orders</h1>
            <p class="page-subtitle" style="margin-bottom:0;">
                Manage medicine inventory, track real-time patient cart orders, and update delivery fulfillment statuses.
            </p>
        </div>

        <div style="display:flex;gap:10px;align-items:center;">
            <button popovertarget="create-medicine-modal" class="open-btn" style="display:inline-flex;align-items:center;gap:8px;">
                <i class="fa-solid fa-plus"></i> Add New Medicine
            </button>
        </div>
    </div>

    <!-- =====================================================
         FLASH NOTIFICATIONS (SUCCESS / ERROR)
    ====================================================== -->
    @if(session('success'))
        <div class="alert alert-success" id="success-message" style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:10px;background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;margin-bottom:20px;font-weight:500;">
            <i class="fa-solid fa-circle-check" style="color:#059669;font-size:18px;"></i>
            <span>{{ session('success') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3500);
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="error-message" style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:10px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;margin-bottom:20px;font-weight:500;">
            <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;font-size:18px;"></i>
            <span>{{ session('error') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const msg = document.getElementById('error-message');
                if (msg) {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <!-- =====================================================
         STATISTICS CARDS (APPOINTMENT PAGE DESIGN)
    ====================================================== -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
        
        <!-- Total Ordered Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-boxes-packing"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Total Ordered</span>
                <strong style="font-size:22px;color:#1e293b;font-weight:700;">{{ $stats['total_ordered'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Delivered Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-truck-ramp-box"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Delivered Orders</span>
                <strong style="font-size:22px;color:#059669;font-weight:700;">{{ $stats['delivered'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Pending Card -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#fffbeb;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Pending Orders</span>
                <strong style="font-size:22px;color:#d97706;font-weight:700;">{{ $stats['pending'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Total Medicines in Inventory -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#faf5ff;color:#7e22ce;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-prescription-bottle-medical"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Inventory Items</span>
                <strong style="font-size:22px;color:#7e22ce;font-weight:700;">{{ $stats['total_medicines'] ?? 0 }}</strong>
            </div>
        </div>

        <!-- Low / Out of Stock Alert -->
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,0.03);display:flex;align-items:center;gap:16px;">
            <div style="width:48px;height:48px;border-radius:10px;background:#fef2f2;color:#dc2626;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <span style="font-size:13px;color:#64748b;font-weight:500;display:block;">Low / Out of Stock</span>
                <strong style="font-size:22px;color:#dc2626;font-weight:700;">{{ $stats['low_stock'] ?? 0 }}</strong>
            </div>
        </div>

    </div>

    <!-- =====================================================
         TAB NAVIGATION
    ====================================================== -->
    @php
        $currentTab = request('tab', $activeTab ?? 'inventory');
    @endphp

    <div style="display:flex;gap:10px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        
        <a href="{{ route('admin.medicines.index', array_merge(request()->except('tab'), ['tab' => 'inventory'])) }}"
           style="display:inline-flex;align-items:center;gap:10px;padding:12px 20px;font-size:14.5px;font-weight:700;text-decoration:none;border-radius:8px 8px 0 0;position:relative;bottom:-2px;transition:all 0.2s;{{ $currentTab === 'inventory' ? 'color:#2563eb;border-bottom:3px solid #2563eb;background:#ffffff;' : 'color:#64748b;background:transparent;' }}">
            <i class="fa-solid fa-pills"></i>
            <span>Medicine Inventory</span>
            <span style="background:{{ $currentTab === 'inventory' ? '#eff6ff' : '#f1f5f9' }};color:{{ $currentTab === 'inventory' ? '#2563eb' : '#64748b' }};font-size:12px;font-weight:700;padding:2px 8px;border-radius:12px;">
                {{ $medicines->count() }}
            </span>
        </a>

        <a href="{{ route('admin.medicines.index', array_merge(request()->except('tab'), ['tab' => 'orders'])) }}"
           style="display:inline-flex;align-items:center;gap:10px;padding:12px 20px;font-size:14.5px;font-weight:700;text-decoration:none;border-radius:8px 8px 0 0;position:relative;bottom:-2px;transition:all 0.2s;{{ $currentTab === 'orders' ? 'color:#2563eb;border-bottom:3px solid #2563eb;background:#ffffff;' : 'color:#64748b;background:transparent;' }}">
            <i class="fa-solid fa-cart-flatbed"></i>
            <span>Medicine Orders (Total Ordered)</span>
            <span style="background:{{ $currentTab === 'orders' ? '#eff6ff' : '#f1f5f9' }};color:{{ $currentTab === 'orders' ? '#2563eb' : '#64748b' }};font-size:12px;font-weight:700;padding:2px 8px;border-radius:12px;">
                {{ $orders->count() }}
            </span>
        </a>

    </div>

    <!-- =====================================================
         TAB 1: MEDICINE INVENTORY CONTENT
    ====================================================== -->
    @if($currentTab === 'inventory')

        <!-- Inventory Action & Filters Bar -->
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
            
            <form method="GET" action="{{ route('admin.medicines.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
                <input type="hidden" name="tab" value="inventory">

                <!-- Search Input -->
                <div style="position:relative;">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search medicine name..."
                        style="padding:10px 14px 10px 36px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;width:240px;background:#ffffff;"
                    >
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                </div>

                <!-- Type Filter -->
                <select name="type" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Medicine Types</option>
                    @foreach(['Tablets', 'Capsules', 'Syrup', 'Powder', 'Injection', 'Drips', 'Band', 'Cotton'] as $t)
                        <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>

                <!-- Stock Filter -->
                <select name="stock_status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Stock Statuses</option>
                    <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>In Stock (> 0)</option>
                    <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Low Stock (≤ 5)</option>
                    <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock (0)</option>
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Availability</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active / Available</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive / Paused</option>
                </select>

                <!-- Clear Filters Button -->
                @if(request()->hasAny(['search', 'type', 'stock_status', 'status']) && (request('search') || request('type') !== 'all' || request('stock_status') !== 'all' || request('status') !== 'all'))
                    <a href="{{ route('admin.medicines.index', ['tab' => 'inventory']) }}" style="color:#ef4444;font-size:13px;text-decoration:none;font-weight:600;padding:8px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                        <i class="fa-solid fa-xmark"></i> Clear Filters
                    </a>
                @endif
            </form>

        </div>

        <!-- Inventory Data Table -->
        <div class="doctors-layout">
            <div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:70px;">Image</th>
                            <th>Medicine Name</th>
                            <th>Type</th>
                            <th>Stock</th>
                            <th>Price (FCFA)</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th style="text-align:center;width:140px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($medicines as $med)
                            <tr>
                                <!-- Image -->
                                <td>
                                    @if($med->image)
                                        <img src="{{ asset('storage/' . $med->image) }}" alt="{{ $med->name }}"
                                             style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                                    @else
                                        <div style="width:44px;height:44px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#94a3b8;border:1px solid #e2e8f0;">
                                            <i class="fa-solid fa-capsules"></i>
                                        </div>
                                    @endif
                                </td>

                                <!-- Name & Description -->
                                <td>
                                    <div style="font-weight:700;color:#1e293b;font-size:14.5px;">{{ $med->name }}</div>
                                    @if($med->description)
                                        <div style="font-size:12px;color:#64748b;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $med->description }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Type -->
                                <td>
                                    <span style="background:#f1f5f9;color:#475569;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;">
                                        {{ $med->type }}
                                    </span>
                                </td>

                                <!-- Stock -->
                                <td>
                                    @if($med->stock <= 0)
                                        <span style="background:#fee2e2;color:#dc2626;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;">
                                            Out of Stock (0)
                                        </span>
                                    @elseif($med->stock <= 5)
                                        <span style="background:#fef3c7;color:#d97706;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;">
                                            Low: {{ $med->stock }} left
                                        </span>
                                    @else
                                        <span style="background:#ecfdf5;color:#059669;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;">
                                            {{ $med->stock }} units
                                        </span>
                                    @endif
                                </td>

                                <!-- Price -->
                                <td>
                                    <strong style="color:#059669;font-size:14px;">
                                        {{ number_format($med->price, 0, '.', ' ') }} FCFA
                                    </strong>
                                </td>

                                <!-- Expiry Date -->
                                <td>
                                    @if($med->expiry_date)
                                        <span style="font-size:13px;color:#475569;">
                                            {{ \Carbon\Carbon::parse($med->expiry_date)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;font-size:12px;">N/A</span>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td>
                                    @if($med->status)
                                        <span style="background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;padding:4px 10px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span> Active
                                        </span>
                                    @else
                                        <span style="background:#f1f5f9;color:#64748b;border:1px solid #cbd5e1;padding:4px 10px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span> Paused
                                        </span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="actions-cell" style="text-align:center;">
                                    <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                        <!-- Edit -->
                                        <button type="button" class="icon-btn orange" popovertarget="edit-med-{{ $med->id }}" title="Edit medicine">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- Toggle Status -->
                                        <form method="POST" action="{{ route('admin.medicines.toggleStatus', $med->id) }}" style="display:inline;margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="icon-btn {{ $med->status ? 'red' : 'green' }}" title="{{ $med->status ? 'Pause availability' : 'Activate medicine' }}">
                                                <i class="fa-solid {{ $med->status ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <button type="button" class="icon-btn red" popovertarget="delete-med-{{ $med->id }}" title="Delete medicine">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:36px;color:#64748b;">
                                    <i class="fa-solid fa-capsules" style="font-size:32px;color:#cbd5e1;display:block;margin-bottom:10px;"></i>
                                    No medicines found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination" style="margin-top:16px;">
                    <span style="color:#64748b;font-size:13px;font-weight:600;">
                        Showing {{ $medicines->count() }} medicine(s)
                    </span>
                </div>
            </div>
        </div>

        <!-- =====================================================
             INVENTORY MODALS (PLACED OUTSIDE TABLE FOR CLEAN DOM)
        ====================================================== -->
        @foreach($medicines as $med)
            <!-- Edit Modal -->
            <div id="edit-med-{{ $med->id }}" popover class="modal-box">
                <div class="modal-content" style="max-width:620px;">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Medicine Details</h3>
                        <button type="button" popovertarget="edit-med-{{ $med->id }}" popovertargetaction="hide" class="modal-close-x">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.medicines.update', $med->id) }}" enctype="multipart/form-data" class="doctor-form">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="form-grid">
                                <!-- Image -->
                                <div class="field full">
                                    <label>Medicine Photo</label>
                                    <input type="file" name="image" accept="image/*" style="border:1px dashed #cbd5e1;padding:8px;width:100%;border-radius:6px;">
                                    @if($med->image)
                                        <div style="margin-top:6px;display:flex;align-items:center;gap:8px;font-size:12px;color:#64748b;">
                                            <span>Current Photo:</span>
                                            <img src="{{ asset('storage/' . $med->image) }}" style="width:34px;height:34px;border-radius:6px;object-fit:cover;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Name -->
                                <div class="field full">
                                    <label>Medicine Name *</label>
                                    <input type="text" name="name" value="{{ $med->name }}" required>
                                </div>

                                <!-- Type -->
                                <div class="field">
                                    <label>Medicine Type *</label>
                                    <select name="type" required>
                                        @foreach(['Tablets', 'Capsules', 'Syrup', 'Powder', 'Injection', 'Drips', 'Band', 'Cotton'] as $t)
                                            <option value="{{ $t }}" {{ $med->type === $t ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Stock -->
                                <div class="field">
                                    <label>Stock Quantity *</label>
                                    <input type="number" name="stock" value="{{ $med->stock }}" min="0" required>
                                </div>

                                <!-- Price -->
                                <div class="field">
                                    <label>Price (FCFA) *</label>
                                    <input type="number" name="price" value="{{ (int)$med->price }}" min="0" step="1" required>
                                </div>

                                <!-- Expiry Date -->
                                <div class="field">
                                    <label>Expiry Date *</label>
                                    <input type="date" name="expiry_date" value="{{ \Carbon\Carbon::parse($med->expiry_date)->format('Y-m-d') }}" required>
                                </div>

                                <!-- Description -->
                                <div class="field full">
                                    <label>Description & Dosage Instructions</label>
                                    <textarea name="description" rows="3">{{ $med->description }}</textarea>
                                </div>

                                <!-- Status -->
                                <div class="field full">
                                    <label>Availability Status *</label>
                                    <select name="status" required>
                                        <option value="1" {{ $med->status ? 'selected' : '' }}>Active & Available in Pharmacy</option>
                                        <option value="0" {{ !$med->status ? 'selected' : '' }}>Paused / Unavailable</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" popovertarget="edit-med-{{ $med->id }}" popovertargetaction="hide" class="close-btn">Cancel</button>
                            <button type="submit" class="save-btn"><i class="fa-solid fa-floppy-disk"></i> Update Medicine</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div id="delete-med-{{ $med->id }}" popover class="alert-modal-box">
                <div class="alert-modal-content">
                    <div class="alert-modal-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="alert-modal-title">Delete Medicine Record</h3>
                    <p class="alert-modal-desc">
                        Are you sure you want to remove <strong>{{ $med->name }}</strong> from the pharmacy inventory?
                    </p>
                    <div class="alert-modal-box-warning">
                        <strong>Warning:</strong> This item will no longer be available for patient orders.
                    </div>
                    <div class="alert-modal-actions">
                        <button type="button" popovertarget="delete-med-{{ $med->id }}" popovertargetaction="hide" class="btn-modal-cancel">Cancel</button>
                        <form method="POST" action="{{ route('admin.medicines.delete', $med->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modal-danger">
                                <i class="fa-solid fa-trash"></i> Yes, Delete Medicine
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    <!-- =====================================================
         TAB 2: MEDICINE ORDERS (TOTAL ORDERED FROM CART)
    ====================================================== -->
    @else

        <!-- Orders Action & Filters Bar -->
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:20px;">
            
            <form method="GET" action="{{ route('admin.medicines.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
                <input type="hidden" name="tab" value="orders">

                <!-- Search Input -->
                <div style="position:relative;">
                    <input
                        type="text"
                        name="order_search"
                        value="{{ request('order_search') }}"
                        placeholder="Search order #, patient..."
                        style="padding:10px 14px 10px 36px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;outline:none;width:260px;background:#ffffff;"
                    >
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                </div>

                <!-- Order Status Filter -->
                <select name="order_status" onchange="this.form.submit()" style="padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;">
                    <option value="all">All Order Statuses</option>
                    <option value="pending" {{ request('order_status') === 'pending' ? 'selected' : '' }}>⏳ Pending Fulfillment</option>
                    <option value="delivered" {{ request('order_status') === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                    <option value="processing" {{ request('order_status') === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                    <option value="cancelled" {{ request('order_status') === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>

                <!-- Clear Filters Button -->
                @if(request()->hasAny(['order_search', 'order_status']) && (request('order_search') || request('order_status') !== 'all'))
                    <a href="{{ route('admin.medicines.index', ['tab' => 'orders']) }}" style="color:#ef4444;font-size:13px;text-decoration:none;font-weight:600;padding:8px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                        <i class="fa-solid fa-xmark"></i> Clear Filters
                    </a>
                @endif
            </form>

        </div>

        <!-- Orders Data Table (Carefully Arranged & Structured) -->
        <div class="doctors-layout">
            <div>
                <table class="data-table" style="table-layout: auto;">
                    <thead>
                        <tr>
                            <th style="width:140px;">Order #</th>
                            <th style="min-width:180px;">Patient Details</th>
                            <th style="min-width:200px;">Items Ordered</th>
                            <th style="width:130px;">Total Amount</th>
                            <th style="width:130px;">Date & Time</th>
                            <th style="width:120px;text-align:center;">Status</th>
                            <th style="width:230px;text-align:center;">Fulfillment Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $patientName = $order->user->name ?? ($order->patient->user->name ?? 'Walk-in Patient');
                                $patientEmail = $order->user->email ?? ($order->patient->user->email ?? 'N/A');
                            @endphp
                            <tr>
                                <!-- Order Number -->
                                <td>
                                    <span style="display:inline-flex;align-items:center;gap:5px;background:#eff6ff;color:#1d4ed8;padding:4px 8px;border-radius:6px;font-family:monospace;font-size:12.5px;font-weight:700;border:1px solid #dbeafe;">
                                        <i class="fa-solid fa-receipt" style="font-size:11px;"></i>
                                        {{ $order->order_number ?? ('#' . $order->id) }}
                                    </span>
                                </td>

                                <!-- Patient Name & Contact -->
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);color:#ffffff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;flex-shrink:0;">
                                            {{ strtoupper(substr($patientName, 0, 2)) }}
                                        </div>
                                        <div style="overflow:hidden;">
                                            <div style="font-weight:700;color:#1e293b;font-size:13.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                {{ $patientName }}
                                            </div>
                                            <div style="font-size:11.5px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                {{ $patientEmail }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Items Ordered -->
                                <td>
                                    <div style="display:flex;flex-wrap:wrap;gap:5px;">
                                        @foreach($order->items->take(2) as $item)
                                            <span style="background:#f8fafc;border:1px solid #e2e8f0;padding:3px 8px;border-radius:6px;font-size:12px;color:#334155;display:inline-flex;align-items:center;gap:5px;">
                                                <strong style="color:#2563eb;">{{ $item->quantity }}x</strong> {{ $item->medicine->name ?? 'Item' }}
                                            </span>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:3px 8px;border-radius:6px;font-size:11.5px;font-weight:700;">
                                                +{{ $order->items->count() - 2 }} more
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Total Amount -->
                                <td>
                                    <strong style="color:#059669;font-size:14.5px;font-weight:800;">
                                        {{ number_format($order->total_amount, 0, '.', ' ') }} FCFA
                                    </strong>
                                </td>

                                <!-- Date & Delivered Time -->
                                <td>
                                    <div style="font-size:13px;color:#1e293b;font-weight:600;white-space:nowrap;">
                                        {{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div style="font-size:11px;color:#64748b;">
                                        {{ $order->created_at ? $order->created_at->format('h:i A') : '' }}
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td style="text-align:center;">
                                    @if($order->status === 'delivered')
                                        <span style="background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-circle-check" style="color:#10b981;font-size:12px;"></i> Delivered
                                        </span>
                                    @elseif($order->status === 'pending')
                                        <span style="background:#fffbeb;color:#92400e;border:1px solid #fde68a;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-clock" style="color:#f59e0b;font-size:12px;"></i> Pending
                                        </span>
                                    @elseif($order->status === 'processing')
                                        <span style="background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-spinner fa-spin" style="color:#3b82f6;font-size:12px;"></i> Processing
                                        </span>
                                    @else
                                        <span style="background:#fef2f2;color:#991b1b;border:1px solid #fecaca;padding:5px 12px;border-radius:99px;font-size:11.5px;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                                            <i class="fa-solid fa-ban" style="color:#ef4444;font-size:12px;"></i> Cancelled
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions: Delivered / Pending / View Details / Delete -->
                                <td class="actions-cell" style="text-align:center;">
                                    <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                        
                                        <!-- Action: Mark Delivered -->
                                        @if($order->status !== 'delivered')
                                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display:inline;margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" style="background:#10b981;color:#ffffff;border:none;padding:6px 10px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:all 0.15s;" title="Mark as Delivered">
                                                    <i class="fa-solid fa-check"></i> Delivered
                                                </button>
                                            </form>
                                        @else
                                            <!-- Action: Revert to Pending -->
                                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display:inline;margin:0;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" style="background:#f59e0b;color:#ffffff;border:none;padding:6px 10px;border-radius:7px;font-size:11.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:all 0.15s;" title="Mark as Pending">
                                                    <i class="fa-solid fa-rotate-left"></i> Pending
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Action: View Details Modal Trigger -->
                                        <button type="button" class="icon-btn blue" popovertarget="view-order-{{ $order->id }}" title="View full order details">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Action: Delete Order -->
                                        <button type="button" class="icon-btn red" popovertarget="delete-order-{{ $order->id }}" title="Cancel / Delete order">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:36px;color:#64748b;">
                                    <i class="fa-solid fa-cart-shopping" style="font-size:32px;color:#cbd5e1;display:block;margin-bottom:10px;"></i>
                                    No patient medicine orders placed yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination" style="margin-top:16px;">
                    <span style="color:#64748b;font-size:13px;font-weight:600;">
                        Showing {{ $orders->count() }} order(s)
                    </span>
                </div>
            </div>
        </div>

        <!-- =====================================================
             ORDER MODALS (PLACED OUTSIDE TABLE FOR CLEAN DOM)
        ====================================================== -->
        @foreach($orders as $order)
            @php
                $patientName = $order->user->name ?? ($order->patient->user->name ?? 'Walk-in Patient');
                $patientEmail = $order->user->email ?? ($order->patient->user->email ?? 'N/A');
            @endphp

            <!-- View Order Details Modal -->
            <div id="view-order-{{ $order->id }}" popover class="modal-box">
                <div class="modal-content" style="max-width:640px;">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <i class="fa-solid fa-receipt"></i> Order Summary — {{ $order->order_number ?? ('#' . $order->id) }}
                        </h3>
                        <button type="button" popovertarget="view-order-{{ $order->id }}" popovertargetaction="hide" class="modal-close-x">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body" style="padding:20px;">
                        <!-- Order Metadata -->
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;background:#f8fafc;padding:14px;border-radius:10px;border:1px solid #e2e8f0;margin-bottom:18px;">
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Patient Name</span>
                                <strong style="display:block;font-size:14px;color:#0f172a;">{{ $patientName }}</strong>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Contact Email</span>
                                <strong style="display:block;font-size:14px;color:#0f172a;">{{ $patientEmail }}</strong>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Order Placed</span>
                                <span style="display:block;font-size:13px;color:#334155;">{{ $order->created_at ? $order->created_at->format('M d, Y - h:i A') : 'N/A' }}</span>
                            </div>
                            <div>
                                <span style="font-size:11.5px;color:#64748b;font-weight:600;text-transform:uppercase;">Delivery Status</span>
                                <span style="display:block;font-size:13px;font-weight:700;color:{{ $order->status === 'delivered' ? '#059669' : '#d97706' }};">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Ordered Items Breakdown Table -->
                        <h4 style="font-size:14px;font-weight:700;margin-bottom:10px;color:#1e293b;">Medicine Items</h4>
                        <table style="width:100%;border-collapse:collapse;margin-bottom:16px;font-size:13px;">
                            <thead>
                                <tr style="background:#f1f5f9;text-align:left;color:#475569;font-weight:700;">
                                    <th style="padding:8px 10px;border-radius:6px 0 0 6px;">Medicine</th>
                                    <th style="padding:8px 10px;">Qty</th>
                                    <th style="padding:8px 10px;">Unit Price</th>
                                    <th style="padding:8px 10px;text-align:right;border-radius:0 6px 6px 0;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr style="border-bottom:1px solid #f1f5f9;">
                                        <td style="padding:10px;font-weight:600;color:#1e293b;">
                                            {{ $item->medicine->name ?? 'Medicine item' }}
                                            @if($item->medicine && $item->medicine->type)
                                                <span style="font-size:11px;color:#64748b;">({{ $item->medicine->type }})</span>
                                            @endif
                                        </td>
                                        <td style="padding:10px;color:#475569;">{{ $item->quantity }}</td>
                                        <td style="padding:10px;color:#475569;">{{ number_format($item->unit_price, 0, '.', ' ') }} FCFA</td>
                                        <td style="padding:10px;text-align:right;font-weight:700;color:#0f172a;">
                                            {{ number_format($item->total_price, 0, '.', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Order Grand Total -->
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#ecfdf5;border-radius:8px;border:1px solid #a7f3d0;">
                            <span style="font-weight:700;color:#065f46;font-size:14px;">Total Paid / Billed:</span>
                            <strong style="color:#059669;font-size:18px;">{{ number_format($order->total_amount, 0, '.', ' ') }} FCFA</strong>
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if($order->status !== 'delivered')
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display:inline;margin:0;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="save-btn" style="background:#10b981;">
                                    <i class="fa-solid fa-check"></i> Mark as Delivered
                                </button>
                            </form>
                        @endif
                        <button type="button" popovertarget="view-order-{{ $order->id }}" popovertargetaction="hide" class="close-btn">Close</button>
                    </div>
                </div>
            </div>

            <!-- Delete Order Modal -->
            <div id="delete-order-{{ $order->id }}" popover class="alert-modal-box">
                <div class="alert-modal-content">
                    <div class="alert-modal-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="alert-modal-title">Delete / Cancel Order</h3>
                    <p class="alert-modal-desc">
                        Are you sure you want to delete order <strong>{{ $order->order_number ?? ('#' . $order->id) }}</strong> placed by <strong>{{ $patientName }}</strong>?
                    </p>
                    <div class="alert-modal-box-warning">
                        <strong>Irreversible Action:</strong> This order record and its items will be permanently erased.
                    </div>
                    <div class="alert-modal-actions">
                        <button type="button" popovertarget="delete-order-{{ $order->id }}" popovertargetaction="hide" class="btn-modal-cancel">Cancel</button>
                        <form method="POST" action="{{ route('admin.orders.delete', $order->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modal-danger">
                                <i class="fa-solid fa-trash"></i> Yes, Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

    <!-- =====================================================
         CREATE NEW MEDICINE MODAL (POPOVER)
    ====================================================== -->
    <div id="create-medicine-modal" popover class="modal-box">
        <div class="modal-content" style="max-width:640px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fa-solid fa-capsules"></i> Add New Medicine to Pharmacy
                </h3>
                <button type="button" popovertarget="create-medicine-modal" popovertargetaction="hide" class="modal-close-x">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.medicines.store') }}" enctype="multipart/form-data" class="doctor-form">
                @csrf

                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom:16px;">
                            <strong>Please correct the following errors:</strong>
                            <ul style="margin-top:6px;padding-left:20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-grid">
                        <!-- Image -->
                        <div class="field full">
                            <label for="new_image">Medicine Image</label>
                            <input type="file" id="new_image" name="image" accept="image/*" style="border:1px dashed #cbd5e1;padding:8px;width:100%;border-radius:6px;">
                        </div>

                        <!-- Name -->
                        <div class="field full">
                            <label for="new_name">Medicine Name *</label>
                            <input type="text" id="new_name" name="name" value="{{ old('name') }}" placeholder="e.g. Paracetamol 500mg" required>
                        </div>

                        <!-- Type -->
                        <div class="field">
                            <label for="new_type">Medicine Type *</label>
                            <select id="new_type" name="type" required>
                                <option value="">Select Type</option>
                                @foreach(['Tablets', 'Capsules', 'Syrup', 'Powder', 'Injection', 'Drips', 'Band', 'Cotton'] as $t)
                                    <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock -->
                        <div class="field">
                            <label for="new_stock">Initial Stock Quantity *</label>
                            <input type="number" id="new_stock" name="stock" value="{{ old('stock', 50) }}" min="0" placeholder="e.g. 100" required>
                        </div>

                        <!-- Price -->
                        <div class="field">
                            <label for="new_price">Price (FCFA) *</label>
                            <input type="number" id="new_price" name="price" value="{{ old('price') }}" min="0" step="1" placeholder="e.g. 1500" required>
                        </div>

                        <!-- Expiry Date -->
                        <div class="field">
                            <label for="new_expiry">Expiry Date *</label>
                            <input type="date" id="new_expiry" name="expiry_date" value="{{ old('expiry_date') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="field full">
                            <label for="new_desc">Description & Instructions</label>
                            <textarea id="new_desc" name="description" rows="3" placeholder="Enter medicine details, dosage, usage guidelines...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="required-note" style="margin-top:12px;font-size:12px;color:#64748b;">
                        <i class="fa-solid fa-circle-info"></i> All fields marked with * are required.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" popovertarget="create-medicine-modal" popovertargetaction="hide" class="close-btn">Cancel</button>
                    <button type="submit" class="save-btn"><i class="fa-solid fa-plus"></i> Save to Inventory</button>
                </div>
            </form>
        </div>
    </div>

    <!-- =====================================================
         ACTION GUIDE (MATCHING SYSTEM STANDARDS)
    ====================================================== -->
    <div class="action-guide" style="margin-top:30px;">
        <div class="guide-title">Pharmacy Management Guide</div>
        <div class="guide-grid">
            <div class="guide-item">
                <div class="guide-icon blue"><i class="fa-solid fa-pen"></i></div>
                <div>
                    <strong>Edit Medicine</strong>
                    <span>Update pricing, batch stocks, expiry dates, and product images.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon green"><i class="fa-solid fa-check"></i></div>
                <div>
                    <strong>Mark Delivered</strong>
                    <span>Confirm patient order fulfillment and auto-record delivery timestamp.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon" style="background:#fffbeb;color:#d97706;"><i class="fa-solid fa-rotate-left"></i></div>
                <div>
                    <strong>Pending Revert</strong>
                    <span>Re-queue order status back to pending dispatch if needed.</span>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon red"><i class="fa-solid fa-trash"></i></div>
                <div>
                    <strong>Cancel / Delete</strong>
                    <span>Permanently remove obsolete records from pharmacy history.</span>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
