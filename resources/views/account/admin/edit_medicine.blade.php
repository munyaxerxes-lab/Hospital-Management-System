@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:14px;color:#64748b;">
        <a href="{{ route('admin.dashboard') }}" style="color:#095eff;text-decoration:none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <a href="{{ route('admin.medicines.index') }}" style="color:#095eff;text-decoration:none;">Pharmacy</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <span style="color:#1e293b;font-weight:600;">Edit {{ $medicine->name }}</span>
    </div>

    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-title" style="margin-bottom:6px;font-size:26px;font-weight:700;color:#0f172a;">
                Edit Medicine Item
            </h1>
            <p class="page-subtitle" style="margin:0;color:#64748b;font-size:15px;">
                Update stock levels, pricing, category, expiry date, and medicine image.
            </p>
        </div>

        <a href="{{ route('admin.medicines.index') }}" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 18px;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-size:14px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Pharmacy
        </a>
    </div>

    {{-- ERROR ALERTS --}}
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

    <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,0.04);padding:32px;max-width:840px;margin:0 auto 40px auto;">

        <form method="POST" action="{{ route('admin.medicines.update', $medicine->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">

                <!-- Medicine Name -->
                <div style="grid-column:1/-1;">
                    <label for="name" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Medicine Name <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $medicine->name) }}"
                        placeholder="e.g. Paracetamol 500mg"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Dosage Form / Type -->
                <div>
                    <label for="type" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Dosage Form / Type <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="type" name="type" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        @foreach(['Capsules', 'Tablets', 'Syrup', 'Powder', 'Band', 'Injection', 'Cotton', 'Drips'] as $t)
                            <option value="{{ $t }}" {{ old('type', $medicine->type) === $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Available Stock -->
                <div>
                    <label for="stock" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Stock Count (Units) <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="{{ old('stock', $medicine->stock) }}"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Unit Price -->
                <div>
                    <label for="price" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Unit Price (XAF) <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="10"
                            value="{{ old('price', $medicine->price) }}"
                            required
                            style="width:100%;padding:12px 60px 12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                        >
                        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748b;font-weight:700;font-size:14px;pointer-events:none;">
                            XAF
                        </span>
                    </div>
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Expiry Date <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="date"
                        id="expiry_date"
                        name="expiry_date"
                        value="{{ old('expiry_date', $medicine->expiry_date ? date('Y-m-d', strtotime($medicine->expiry_date)) : '') }}"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Availability Status -->
                <div>
                    <label for="status" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Catalog Status <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="status" name="status" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        <option value="1" {{ old('status', $medicine->status ? '1' : '0') === '1' ? 'selected' : '' }}>Active / Listed</option>
                        <option value="0" {{ old('status', $medicine->status ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive / Hidden</option>
                    </select>
                </div>

                <!-- Product Image -->
                <div>
                    <label for="image" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Medicine Image (Optional)
                    </label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                        style="width:100%;padding:9px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;"
                    >
                </div>

                <!-- Description -->
                <div style="grid-column:1/-1;">
                    <label for="description" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Description / Indications (Optional)
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="e.g. Pain reliever and fever reducer..."
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >{{ old('description', $medicine->description) }}</textarea>
                </div>

            </div>

            <!-- Form Actions -->
            <div style="margin-top:36px;border-top:1.5px solid #e2e8f0;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button
                        type="submit"
                        style="background:#095eff;color:#ffffff;border:none;padding:14px 32px;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;display:inline-flex;align-items:center;gap:10px;box-shadow:0 3px 12px rgba(9,94,255,0.3);transition:all 0.2s;"
                    >
                        <i class="fa-solid fa-check"></i> Update Medicine
                    </button>
                    <a
                        href="{{ route('admin.medicines.index') }}"
                        style="background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:14px 24px;border-radius:8px;font-weight:600;font-size:15px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;"
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

@endsection
