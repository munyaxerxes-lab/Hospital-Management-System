@extends('admin_layout.index')

@section('content')
<section class="page" style="padding-bottom: 50px;">
    <div class="settings-wrapper" style="max-width: 840px; margin: 0 auto;">
        
        <h1 class="page-title" style="margin-bottom: 6px;">Admin Account Settings</h1>
        <p class="page-subtitle" style="margin-bottom: 28px;">
            Manage your personal profile information, contact details, and security credentials.
        </p>

        <!-- Global Success Notification Banner -->
        @if (session('status'))
            <div style="padding: 14px 18px; background-color: #ecfdf5; color: #065f46; border-radius: 10px; margin-bottom: 1.8rem; border: 1px solid #a7f3d0; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 18px;"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Global Error Validation Summary Banner -->
        @if ($errors->any())
            <div style="padding: 14px 18px; background-color: #fef2f2; color: #991b1b; border-radius: 10px; margin-bottom: 1.8rem; border: 1px solid #fecaca;">
                <div style="font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom: 4px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CARD 1: Update Basic Profile (Name) -->
        <div class="card" style="background: #ffffff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Personal Profile Details</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Update your official display name</p>
                </div>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <button type="submit" style="background: #095eff; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s;">
                    Save Profile
                </button>
            </form>
        </div>

        <!-- CARD 2: Update Phone Number -->
        <div class="card" style="background: #ffffff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Contact Information</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Update your contact telephone number</p>
                </div>
            </div>
            <form action="{{ route('admin.profile.change-phone') }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +237..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <button type="submit" style="background: #059669; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s;">
                    Update Phone Number
                </button>
            </form>
        </div>

        <!-- CARD 3: Change Email Address -->
        <div class="card" style="background: #ffffff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Account Email Address</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Change your login email credentials</p>
                </div>
            </div>
            <form action="{{ route('admin.profile.change-email') }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">New Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter new email address..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">Current Password Confirmation</label>
                    <input type="password" name="current_password" placeholder="Enter your current password to verify..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <button type="submit" style="background: #ea580c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s;">
                    Update Email Address
                </button>
            </form>
        </div>

        <!-- CARD 4: Update Password -->
        <div class="card" style="background: #ffffff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #f5f3ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">Security Password</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Ensure your administrator account uses a strong password</p>
                </div>
            </div>
            <form action="{{ route('admin.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">Current Password</label>
                    <input type="password" name="current_password" placeholder="Enter current password..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">New Password (Min 8 characters)</label>
                    <input type="password" name="password" placeholder="Enter new strong password..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password..." required style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
                </div>
                <button type="submit" style="background: #7c3aed; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; transition: background 0.2s;">
                    Update Security Password
                </button>
            </form>
        </div>

        <!-- CARD 5: Danger Zone - Delete Account -->
        <!-- <div class="card" style="background: #ffffff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; border: 1px solid #fee2e2;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #fee2e2;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #991b1b;">Danger Zone</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Permanent deletion of your administrator account</p>
                </div>
            </div>
            <p style="font-size: 14px; color: #475569; margin-bottom: 18px; line-height: 1.5;">
                Once your administrator account is deleted, all access permissions and data linked with this account will be irreversibly removed.
            </p>
            <button type="button" popovertarget="delete-account-modal" class="btn-modal-danger" style="padding: 10px 20px;">
                <i class="fa-solid fa-trash"></i> Delete Account
            </button>
        </div> -->

    </div>
</section>
@endsection
