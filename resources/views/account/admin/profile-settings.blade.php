@extends('admin_layout.main') <!-- Extends your header outer shell frame -->

@section('content')
<div class="settings-wrapper" style="max-width: 800px; margin: 0 auto; padding: 1.5rem 1rem; font-family: sans-serif;">
    
    <h2 style="color: #164dad; margin-bottom: 1.5rem;">⚙️ Admin Account Settings</h2>

    <!-- Global Success Notification Banner -->
    @if (session('status'))
        <div style="padding: 12px 16px; background-color: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb; font-weight: 500;">
            ✅ {{ session('status') }}
        </div>
    @endif

    <!-- Global Error Validation Summary Banner -->
    @if ($errors->any())
        <div style="padding: 12px 16px; background-color: #f8d7da; color: #721c24; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom: 4px;">⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CARD 1: Update Basic Profile (Name) -->
    <div class="settings-card" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 1.5rem; border: 1px solid #eef0f6;">
        <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #f4f6f9; padding-bottom: 0.5rem;">👤 Update Profile Details</h3>
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="background: #164dad; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: bold;">Save Name</button>
        </form>
    </div>

    <!-- CARD 2: Update Phone Number -->
    <div class="settings-card" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 1.5rem; border: 1px solid #eef0f6;">
        <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #f4f6f9; padding-bottom: 0.5rem;">📞 Update Contact Information</h3>
        <form action="{{ route('admin.profile.change-phone') }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +237..." required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="background: #164dad; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: bold;">Update Phone</button>
        </form>
    </div>

    <!-- CARD 3: Change Email Address -->
    <div class="settings-card" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 1.5rem; border: 1px solid #eef0f6;">
        <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #f4f6f9; padding-bottom: 0.5rem; color: #e67e22;">✉️ Change Email Address</h3>
        <form action="{{ route('admin.profile.change-email') }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">New Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter new email..." required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">Confirm Password</label>
                <input type="password" name="current_password" placeholder="Verify your current password..." required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="background: #e67e22; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: bold;">Update Email</button>
        </form>
    </div>

    <!-- CARD 4: Update Password -->
    <div class="settings-card" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 1.5rem; border: 1px solid #eef0f6;">
        <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #f4f6f9; padding-bottom: 0.5rem; color: #27ae60;">🔒 Security Password Update</h3>
        <form action="{{ route('admin.profile.update-password') }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">Current Password</label>
                <input type="password" name="current_password" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">New Password (Min 8 chars)</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #555;">Confirm New Password</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="background: #27ae60; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; cursor: pointer; font-weight: bold;">Change Password</button>
        </form>
    </div>

</div>
@endsection
