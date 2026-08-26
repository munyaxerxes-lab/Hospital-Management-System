@extends('admin_layout.index')
@section('content')

<section class="page">
    <h1 class="page-title">Manage Medicine Orders</h1>
    <p class="page-subtitle">View and manage all medicine orders placed by patients.</p>

    <!-- Create Medicine Button -->
    <button popovertarget="my-modal" class="open-btn">
         Add Medicines
    </button>

    <!-- =========================
         CREATE MEDICINE MODAL
    ========================== -->
    <div id="my-modal" popover class="modal-box">
        <div class="modal-content">

            <!-- CRITICAL: Added enctype="..." to allow file uploading -->
            <form method="POST" action="{{ route('admin.medicines.store') }}" enctype="multipart/form-data" class="doctor-form">
                @csrf

                <div class="form-title">Add New Medicine to Pharmacy</div>

                <!-- Validation Summary -->
                @if ($errors->any())
                    <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                        <strong>Please correct the following errors:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid">

                    <!-- Image Upload Field (Full Width at Top) -->
                    <div class="field full" style="margin-bottom: 15px;">
                        <label for="image">Medicine Image</label>
                        <input type="file" id="image" name="image" accept="image/*" style="border: 1px dashed #ccc; padding: 10px; width: 100%;height: 3rem; border-radius: 4px;">
                        @error('image') <small class="error-message" style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    <!-- Medicine Name -->
                    <div class="field full">
                        <label for="name">Medicine Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
                        @error('name') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Type -->
                    <div class="field">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="">Select Type</option>
                            @foreach(['Tablets', 'Capsules', 'Syrup', 'Powder', 'Injection', 'Drips', 'Band', 'Cotton'] as $typeOption)
                                <option value="{{ $typeOption }}" {{ old('type') == $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
                            @endforeach
                        </select>
                        @error('type') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Stock -->
                    <div class="field">
                        <label for="stock">Stock Quantity *</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock') }}" placeholder="Enter stock quantity" min="0" required>
                        @error('stock') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Price -->
                    <div class="field">
                        <label for="price">Price (FCFA) *</label>
                        <input type="number" id="price" name="price" step="1" value="{{ old('price') }}" placeholder="Enter price" min="0" required>
                        @error('price') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div class="field">
                        <label for="expiry_date">Expiry Date *</label>
                        <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                        @error('expiry_date') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Status -->
                    <div class="field">
                        <label for="status">Initial Availability *</label>
                        <select id="status" name="status" required>
                            <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        @error('status') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                    <!-- Description -->
                    <div class="field full">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Enter short description" rows="3">{{ old('description') }}</textarea>
                        @error('description') <small class="error-message">{{ $message }}</small> @enderror
                    </div>

                </div>

                <!-- Form Controls Actions -->
                <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" class="submit-btn">Save Medicine</button>
                    <button type="button" popovertarget="my-modal" popovertargetaction="hide" class="cancel-btn">Cancel</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Success Message Toast Alert -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin: 15px 0;">
            {{ session('success') }}
        </div>
    @endif

    <!-- =========================
         MEDICINES DATA TABLE
    ========================== -->
    <div style="margin-top: 30px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; width: 80px;">Image</th>
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Type</th>
                    <th style="padding: 12px;">Stock</th>
                    <th style="padding: 12px;">Price (FCFA)</th>
                    <th style="padding: 12px;">Expiry</th>
                    <th style="padding: 12px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $med)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <!-- Image Element Column -->
                        <td style="padding: 12px;">
                            @if($med->image)
                                <img src="{{ asset('storage/' . $med->image) }}" alt="{{ $med->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb;">
                            @else
                                <div style="width: 50px; height: 50px; background: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #6b7280; font-weight: bold;">
                                    NO IMG
                                </div>
                            @endif
                        </td>
                        <td style="padding: 12px; font-weight: bold; vertical-align: middle;">{{ $med->name }}</td>
                        <td style="padding: 12px; vertical-align: middle;">{{ $med->type }}</td>
                        <td style="padding: 12px; vertical-align: middle;">{{ $med->stock }}</td>
                        <!-- FIXED: Appended FCFA and removed the dollar sign formatting -->
                        <td style="padding: 12px; vertical-align: middle;">{{ number_format($med->price, 0, '.', ' ') }} FCFA</td>
                        <td style="padding: 12px; vertical-align: middle;">{{ \Carbon\Carbon::parse($med->expiry_date)->format('Y-m-d') }}</td>
                        <td style="padding: 12px; vertical-align: middle;">
                            <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; background: {{ $med->status ? '#d1fae5; color: #065f46;' : '#fee2e2; color: #991b1b;' }}">
                                {{ $med->status ? 'Available' : 'Out of Stock' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 20px; text-align: center; color: #6b7280;">No medicines found in pharmacy storage.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection
