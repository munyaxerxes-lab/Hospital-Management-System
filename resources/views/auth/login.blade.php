<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediLink — Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

    * { box-sizing: border-box; }
    body {
      margin:0; padding:0; min-height:100vh;
      font-family:'Segoe UI', Roboto, Arial, sans-serif;
      background:#FFFFFF;
      display:flex; align-items:center; justify-content:center;
      padding:40px 20px;
    }
    input { font-family:inherit; }
    input:focus { outline:none; border-color:#1554B3 !important; box-shadow:0 0 0 3px rgba(21,84,179,0.12); }
    .btn-primary {
      background:#1554B3; color:#fff; border:none; border-radius:999px;
      font-weight:700; font-size:15px; padding:13px 20px; cursor:pointer;
      transition:background .15s ease;
      box-shadow: 0 6px 16px rgba(21,84,179,0.25);
    }
    .btn-primary:hover { background:#0F3E85; }
    .field-label { font-size:13.5px; font-weight:600; color:#374151; margin-bottom:6px; display:block; }
    .field-input {
      width:100%; padding:12px 14px; border-radius:10px; border:1.5px solid #E1E5EB;
      background:#F5F7FA; font-size:14px; color:#16213E;
    }

    .login-card {
      width:100%; max-width:920px; border:1.5px solid white; border-radius:18px;
      padding:48px 56px; display:flex; align-items:center; gap:40px; flex-wrap:wrap;
      box-shadow: 0 10px 40px rgba(2, 65, 255, 0.26);
    }
    .brand-col { flex:1; min-width:280px; text-align:center; }
    .form-col { flex:1; min-width:280px; }
</style>
</head>
<body>

  <div class="login-card">
    <div class="brand-col">
      <img src="{{ asset('image/logo3.png') }}" alt="logo" style=" margin-right: 50rem;">

      <div class="form-col">
      <h1 style="font-size:26px; font-weight:800; color:#16213E; margin:0 0 4px; letter-spacing:-0.01em;">LOGIN</h1>
      <div style="width:64px; height:3px; background:#1554B3; border-radius:2px; margin-bottom:28px; justify-self: center;"></div>
      
      <form method="POST" action="{{ route('login.submit') }}">
        <?php echo csrf_field(); ?>

        <?php if(session('status')): ?>
          <div style="background:#ECFDF5;color:#065F46;padding:10px;border-radius:8px;margin-bottom:14px;font-weight:600;"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        @if ($errors->any())
    <div style="
        background:#FEF2F2;
        color:#991B1B;
        padding:10px;
        border-radius:8px;
        margin-bottom:14px;
        font-weight:600;
    ">
        {{ $errors->first() }}
    </div>
  @endif

        <div style="margin-bottom:20px;">
          <label class="field-label" for="email">Email</label>
          <input class="field-input" type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com" required>
        </div>

        <div style="margin-bottom:10px;">
          <label class="field-label" for="password">Password</label>
          <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div style="text-align:right; margin-bottom:22px;">
          <a href="{{ route('password.request') }}"
            style="color:#E4572E; font-size:13px; font-weight:600; text-decoration:none;">
            Forget password?
          </a>
        </div>

        <button type="submit" class="btn-primary" style="width:30%;">LOGIN</button>

        <p style="text-align:center; font-size:13.5px; color:#6B7280; margin-top:20px;">
          Dont have an account?
          <a href="{{ route('register') }}" style="color:#1554B3; font-weight:700; text-decoration:none;">SignUp</a>
        </p>
      </form>
    </div>
  </div>

</body>
</html>
