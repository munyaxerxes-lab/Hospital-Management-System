<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediLink — Login</title>
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
    .login-container {
      width: 100%;
      max-width: 900px;
      background: #FFFFFF;
      border-radius: 24px;
      box-shadow: 0 20px 45px -10px rgba(15, 30, 65, 0.12), 0 0 1px 1px rgba(226, 232, 240, 0.8);
      overflow: hidden;
      display: flex;
      min-height: 520px;
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
    }
    .brand-footer {
      font-size: 12.5px;
      color: #94A3B8;
      z-index: 1;
    }
    .form-side {
      flex: 1.15;
      padding: 48px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-header {
      margin-bottom: 28px;
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
    .form-group {
      margin-bottom: 18px;
    }
    .field-label {
      font-size: 13.5px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 7px;
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
      font-size: 15px;
    }
    .field-input {
      width: 100%;
      padding: 12px 14px 12px 42px;
      border-radius: 12px;
      border: 1.5px solid #CBD5E1;
      background: #F8FAFC;
      font-size: 14.5px;
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
    .remember-forgot {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      font-size: 13.5px;
    }
    .remember-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #475569;
      cursor: pointer;
    }
    .forgot-link {
      color: #1554B3;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s ease;
    }
    .forgot-link:hover {
      color: #0F3E85;
      text-decoration: underline;
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
    .signup-prompt {
      text-align: center;
      font-size: 14px;
      color: #64748B;
      margin-top: 24px;
    }
    .signup-prompt a {
      color: #1554B3;
      font-weight: 700;
      text-decoration: none;
    }
    .signup-prompt a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .login-container {
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
    }
</style>
</head>
<body>

  <div class="login-container">
    <!-- Brand Side -->
    <div class="brand-side">
      <div class="brand-logo-wrap">
        <img src="{{ asset('image/logo1.png') }}" alt="MediLink Logo" class="brand-logo-img" onerror="this.style.display='none'">
        <span class="brand-title">MediLink</span>
      </div>
      <div class="brand-content">
        <h2>Hospital Management Redefined</h2>
        <p>Seamless clinical appointments, real-time lab test results, smart pharmacy orders, and comprehensive patient care in one unified portal.</p>
      </div>
      <div class="brand-footer">
        &copy; {{ date('Y') }} MediLink Healthcare System
      </div>
    </div>

    <!-- Form Side -->
    <div class="form-side">
      <div class="form-header">
        <h1>Welcome Back</h1>
        <p>Please enter your credentials to access your account</p>
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

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="form-group">
          <label class="field-label" for="email">Email Address</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-envelope input-icon"></i>
            <input class="field-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@medilink.com" required autofocus>
          </div>
        </div>

        <div class="form-group">
          <label class="field-label" for="password">Password</label>
          <div class="input-wrapper">
            <i class="fa-solid fa-lock input-icon"></i>
            <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" required>
          </div>
        </div>

        <div class="remember-forgot">
          <label class="remember-wrap">
            <input type="checkbox" name="remember" id="remember" style="accent-color: #1554B3;">
            <span>Remember me</span>
          </label>
          <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="btn-submit">
          <span>Sign In</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>

        <p class="signup-prompt">
          Don't have an account?
          <a href="{{ route('register') }}">Create an account</a>
        </p>
      </form>
    </div>
  </div>

</body>
</html>
