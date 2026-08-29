<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediLink — Create an Account</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #F0F4F8 0%, #E2E8F0 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 16px;
      color: #1E293B;
    }
    .register-container {
      width: 100%;
      max-width: 900px;
      background: #FFFFFF;
      border-radius: 24px;
      box-shadow: 0 20px 45px -10px rgba(15, 30, 65, 0.12), 0 0 1px 1px rgba(226, 232, 240, 0.8);
      overflow: hidden;
      display: flex;
      min-height: 560px;
    }
    .brand-side {
      flex: 1;
      background: linear-gradient(145deg, #0B2545 0%, #134074 50%, #1554B3 100%);
      padding: 48px 40px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      color: #FFFFFF;
      position: relative;
      overflow: hidden;
    }
    .brand-side::before {
      content: '';
      position: absolute;
      width: 320px;
      height: 320px;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
      top: -100px;
      right: -100px;
      border-radius: 50%;
    }
    .brand-logo-wrap {
      display: flex;
      align-items: center;
      gap: 12px;
      z-index: 1;
    }
    .brand-logo-img {
      height: 48px;
      width: auto;
      object-fit: contain;
      background: #ffffff;
      padding: 6px 12px;
      border-radius: 12px;
    }
    .brand-title {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.02em;
    }
    .brand-content {
      z-index: 1;
      margin: 40px 0;
    }
    .brand-content h2 {
      font-size: 28px;
      font-weight: 800;
      line-height: 1.25;
      margin-bottom: 12px;
    }
    .brand-content p {
      font-size: 14.5px;
      line-height: 1.6;
      color: #CBD5E1;
      margin-bottom: 16px;
    }
    .feature-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13.5px;
      color: #E2E8F0;
    }
    .feature-item i {
      color: #38BDF8;
    }
    .brand-footer {
      font-size: 12.5px;
      color: #94A3B8;
      z-index: 1;
    }
    .form-side {
      flex: 1.25;
      padding: 44px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-header {
      margin-bottom: 24px;
    }
    .form-header h1 {
      font-size: 26px;
      font-weight: 800;
      color: #0F172A;
      letter-spacing: -0.02em;
      margin-bottom: 6px;
    }
    .form-header p {
      font-size: 14px;
      color: #64748B;
    }
    .row-2 {
      display: flex;
      gap: 14px;
    }
    .row-2 > div {
      flex: 1;
      min-width: 0;
    }
    .form-group {
      margin-bottom: 16px;
    }
    .field-label {
      font-size: 13px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 6px;
      display: block;
    }
    .input-wrapper {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      font-size: 14px;
    }
    .field-input {
      width: 100%;
      padding: 11px 14px 11px 40px;
      border-radius: 12px;
      border: 1.5px solid #CBD5E1;
      background: #F8FAFC;
      font-size: 14px;
      color: #0F172A;
      font-family: inherit;
      transition: all 0.2s ease;
    }
    .field-input:focus {
      outline: none;
      border-color: #1554B3;
      background: #FFFFFF;
      box-shadow: 0 0 0 4px rgba(21, 84, 179, 0.12);
    }
    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, #1554B3 0%, #0F3E85 100%);
      color: #FFFFFF;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      padding: 13px 20px;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(21, 84, 179, 0.25);
      transition: all 0.2s ease;
      font-family: inherit;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 8px;
    }
    .btn-submit:hover {
      background: linear-gradient(135deg, #0F3E85 0%, #08295E 100%);
      box-shadow: 0 8px 22px rgba(21, 84, 179, 0.35);
      transform: translateY(-1px);
    }
    .btn-submit:active {
      transform: translateY(0);
    }
    .alert-box {
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 13.5px;
      font-weight: 600;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .alert-error {
      background: #FEF2F2;
      border: 1px solid #FECACA;
      color: #991B1B;
    }
    .alert-success {
      background: #ECFDF5;
      border: 1px solid #A7F3D0;
      color: #065F46;
    }
    .login-prompt {
      text-align: center;
      font-size: 14px;
      color: #64748B;
      margin-top: 20px;
    }
    .login-prompt a {
      color: #1554B3;
      font-weight: 700;
      text-decoration: none;
    }
    .login-prompt a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .register-container {
        flex-direction: column;
        max-width: 480px;
      }
      .brand-side {
        padding: 32px 24px;
      }
      .brand-content {
        margin: 20px 0;
      }
      .form-side {
        padding: 36px 24px;
      }
      .row-2 {
        flex-direction: column;
        gap: 0;
      }
    }
</style>
</head>
<body>

  <div class="register-container">
    <!-- Brand Side -->
    <div class="brand-side">
      <div class="brand-logo-wrap">
        <img src="{{ asset('image/logo1.png') }}" alt="MediLink Logo" class="brand-logo-img" onerror="this.style.display='none'">
        <span class="brand-title">MediLink</span>
      </div>
      <div class="brand-content">
        <h2>Join MediLink Today</h2>
        <p>Register as a patient to book specialist consultations, access medical lab results, and manage your pharmacy prescriptions in one place.</p>
        <ul class="feature-list">
          <li class="feature-item"><i class="fa-solid fa-circle-check"></i> Verified Doctor Appointments</li>
          <li class="feature-item"><i class="fa-solid fa-circle-check"></i> Instant Lab Result Downloads</li>
          <li class="feature-item"><i class="fa-solid fa-circle-check"></i> Direct Prescription Delivery</li>
        </ul>
      </div>
      <div class="brand-footer">
        &copy; {{ date('Y') }} MediLink Healthcare System
      </div>
    </div>

    <!-- Form Side -->
    <div class="form-side">
      <div class="form-header">
        <h1>Create Patient Account</h1>
        <p>Fill in your personal information to get started</p>
      </div>

      @if(session('status'))
        <div class="alert-box alert-success">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="alert-box alert-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label class="field-label" for="name">Full Name</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-user input-icon"></i>
            <input class="field-input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
          </div>
        </div>

        <div class="row-2">
          <div class="form-group">
            <label class="field-label" for="email">Email Address</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-envelope input-icon"></i>
              <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
          </div>
          <div class="form-group">
            <label class="field-label" for="phone">Phone Number</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-phone input-icon"></i>
              <input class="field-input" type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+237 6XX XXX XXX" required>
            </div>
          </div>
        </div>

        <div class="row-2">
          <div class="form-group">
            <label class="field-label" for="password">Password</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-lock input-icon"></i>
              <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
          </div>
          <div class="form-group">
            <label class="field-label" for="password_confirmation">Confirm Password</label>
            <div class="input-wrapper">
              <i class="fa-solid fa-shield-halved input-icon"></i>
              <input class="field-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <span>Create Account</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>

        <p class="login-prompt">
          Already have an account?
          <a href="{{ route('login') }}">Sign In</a>
        </p>
      </form>
    </div>
  </div>

</body>
</html>
