@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 40px;">

    <!-- Breadcrumbs -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:14px;color:#64748b;">
        <a href="{{ route('admin.dashboard') }}" style="color:#095eff;text-decoration:none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <a href="{{ route('admin.doctors.index') }}" style="color:#095eff;text-decoration:none;">Doctors</a>
        <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
        <span style="color:#1e293b;font-weight:600;">Edit Dr. {{ $doctor->doctor_name }}</span>
    </div>

    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-title" style="margin-bottom:6px;font-size:26px;font-weight:700;color:#0f172a;">
                Edit Doctor Profile
            </h1>
            <p class="page-subtitle" style="margin:0;color:#64748b;font-size:15px;">
                Update Dr. {{ $doctor->doctor_name }}'s medical specialty, qualification, experience, and consultation fees.
            </p>
        </div>

        <a href="{{ route('admin.doctors.index') }}" style="background:#f1f5f9;color:#334155;border:1px solid #cbd5e1;padding:10px 18px;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-size:14px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Doctors
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

        <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">

                <!-- Doctor Avatar / Photo -->
                <div style="grid-column:1/-1;">
                    <label for="avatar" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Doctor Profile Photo / Avatar
                    </label>
                    <div style="display:flex;align-items:center;gap:16px;background:#f8fafc;padding:16px;border-radius:10px;border:1.5px dashed #cbd5e1;">
                        @php
                            $currentAvatar = $doctor->avatar 
                                ? (str_starts_with($doctor->avatar, 'http') || str_starts_with($doctor->avatar, 'image/') ? asset($doctor->avatar) : asset('storage/' . $doctor->avatar))
                                : asset('image/doc.png');
                        @endphp
                        <img src="{{ $currentAvatar }}" alt="Current Avatar" style="width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid #095eff;flex-shrink:0;">
                        <div style="flex:1;">
                            <input
                                type="file"
                                id="avatar"
                                name="avatar"
                                accept="image/*"
                                style="width:100%;padding:10px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:14px;background:#fff;outline:none;"
                            >
                            <small style="color:#64748b;display:block;margin-top:4px;font-size:12px;">Upload a new image to replace the current photo (PNG, JPG, WEBP max 4MB).</small>
                        </div>
                    </div>
                    @error('avatar')
                        <small style="color:#ef4444;font-size:13px;display:block;margin-top:4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Doctor Name -->
                <div style="grid-column:1/-1;">
                    <label for="doctor_name" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Doctor Name <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="doctor_name"
                        name="doctor_name"
                        value="{{ old('doctor_name', $doctor->doctor_name) }}"
                        placeholder="e.g. Dr. John Doe"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Specialty -->
                <div>
                    <label for="specialty" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Medical Specialty <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="specialty" name="specialty" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        <option value="">Select specialty</option>
                        @foreach(['Cardiology', 'Neurosurgery', 'Pharmacy', 'Laboratory', 'Pediatrics', 'Orthopedics', 'Gynecology', 'Neurology'] as $spec)
                            <option value="{{ $spec }}" {{ old('specialty', $doctor->specialty) == $spec ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Qualification -->
                <div>
                    <label for="qualification" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Qualification <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="qualification"
                        name="qualification"
                        value="{{ old('qualification', $doctor->qualification) }}"
                        placeholder="e.g. MBBS, MD, PhD"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Years of Experience -->
                <div>
                    <label for="years_of_experience" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Years of Experience <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="number"
                        id="years_of_experience"
                        name="years_of_experience"
                        min="0"
                        max="70"
                        value="{{ old('years_of_experience', $doctor->years_of_experience) }}"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Consultation Fee -->
                <div>
                    <label for="consultation_fee" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Consultation Fee (XAF) <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input
                            type="number"
                            id="consultation_fee"
                            name="consultation_fee"
                            min="0"
                            step="100"
                            value="{{ old('consultation_fee', $doctor->consultation_fee) }}"
                            required
                            style="width:100%;padding:12px 60px 12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                        >
                        <span style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748b;font-weight:700;font-size:14px;pointer-events:none;">
                            XAF
                        </span>
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        System Username <span style="color:#ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username', $doctor->username) }}"
                        placeholder="e.g. dr_john"
                        required
                        style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;outline:none;"
                    >
                </div>

                <!-- Status -->
                <div>
                    <label for="status" style="display:block;font-weight:600;font-size:14px;color:#1e293b;margin-bottom:8px;">
                        Status <span style="color:#ef4444;">*</span>
                    </label>
                    <select id="status" name="status" required style="width:100%;padding:12px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:15px;background:#fff;outline:none;">
                        <option value="active" {{ old('status', $doctor->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $doctor->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <!-- Form Actions -->
            <div style="margin-top:36px;border-top:1.5px solid #e2e8f0;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button
                        type="submit"
                        style="background:#095eff;color:#ffffff;border:none;padding:14px 32px;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;display:inline-flex;align-items:center;gap:10px;box-shadow:0 3px 12px rgba(9,94,255,0.3);transition:all 0.2s;"
                    >
                        <i class="fa-solid fa-check"></i> Save Changes
                    </button>
                    <a
                        href="{{ route('admin.doctors.index') }}"
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
