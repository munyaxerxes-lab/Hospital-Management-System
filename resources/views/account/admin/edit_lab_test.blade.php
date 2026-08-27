@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:14px;color:#64748b;">
        <a href="{{ route('admin.dashboard') }}" style="color:#095eff;text-decoration:none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <a href="{{ route('admin.lab_tests.index', ['tab' => 'catalog']) }}" style="color:#095eff;text-decoration:none;">Laboratory</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <span style="color:#1e293b;font-weight:600;">Edit {{ $lab_test->name }}</span>
    </div>

    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-title" style="margin-bottom:6px;font-size:26px;font-weight:700;color:#0f172a;">
                Edit Diagnostic Test
            </h1>
            <p class="page-subtitle" style="margin:0;color:#64748b;font-size:15px;">
                Update lab test details, diagnostic department, test preparation instructions, and pricing.
            </p>
        </div>

        <a href="{{ route('admin.lab_tests.index', ['tab' => 'catalog']) }}" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 18px;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-size:14px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Laboratory
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

        <form method="POST" action="{{ route('admin.lab_tests.update', $lab_test->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">

                <!-- Test Name -->
                <div style="grid-column:1/-1;">
                    <label for="name" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Test Name <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $lab_test->name) }}"
                        placeholder="e.g. Complete Blood Count (CBC)"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Category / Department -->
                <div>
                    <label for="category" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Department / Category <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="category" name="category" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        @foreach(['Hematology', 'Biochemistry', 'Microbiology', 'Immunology', 'Radiology', 'Parasitology', 'Pathology', 'General'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $lab_test->category) == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Test Price -->
                <div>
                    <label for="price" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Fee (XAF) <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="100"
                            value="{{ old('price', $lab_test->price) }}"
                            required
                            style="width:100%;padding:12px 60px 12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                        >
                        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748b;font-weight:700;font-size:14px;pointer-events:none;">
                            XAF
                        </span>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Catalog Status <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="status" name="status" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        <option value="1" {{ old('status', $lab_test->status ? '1' : '0') === '1' ? 'selected' : '' }}>Available / Active</option>
                        <option value="0" {{ old('status', $lab_test->status ? '1' : '0') === '0' ? 'selected' : '' }}>Unavailable / Inactive</option>
                    </select>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Test Cover Image (Optional)
                    </label>
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                        style="width:100%;padding:9px 12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;"
                    >
                    @if($lab_test->image_url)
                        <div style="margin-top:8px;display:flex;align-items:center;gap:10px;padding:8px 12px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;">
                            <img src="{{ $lab_test->image_url }}" style="width:40px;height:40px;border-radius:6px;object-fit:cover;border:1px solid #cbd5e1;" onerror="this.onerror=null; this.src='{{ asset('image/lab1.png') }}';">
                            <span style="font-size:13px;color:#64748b;">Current test image</span>
                        </div>
                    @endif
                </div>

                <!-- Preparation -->
                <div style="grid-column:1/-1;">
                    <label for="preparation" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Patient Preparation Instructions (Optional)
                    </label>
                    <textarea
                        id="preparation"
                        name="preparation"
                        rows="3"
                        placeholder="e.g. Requires 8-12 hours of overnight fasting prior to sample collection."
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >{{ old('preparation', $lab_test->preparation) }}</textarea>
                </div>

                <!-- Description -->
                <div style="grid-column:1/-1;">
                    <label for="description" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Test Description & Diagnostic Parameters (Optional)
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="e.g. Measures red blood cells, white blood cells, hemoglobin, and platelets..."
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >{{ old('description', $lab_test->description) }}</textarea>
                </div>

            </div>

            <!-- Form Actions -->
            <div style="margin-top:36px;border-top:1.5px solid #e2e8f0;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button
                        type="submit"
                        style="background:#095eff;color:#ffffff;border:none;padding:14px 32px;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;display:inline-flex;align-items:center;gap:10px;box-shadow:0 3px 12px rgba(9,94,255,0.3);transition:all 0.2s;"
                    >
                        <i class="fa-solid fa-check"></i> Update Test
                    </button>
                    <a
                        href="{{ route('admin.lab_tests.index', ['tab' => 'catalog']) }}"
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
