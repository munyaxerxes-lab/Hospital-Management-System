<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediLink — Sign Up</title>
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

    .signup-card {
      width:100%; max-width:640px; border-radius:18px; padding:40px 48px 48px;
      box-shadow: 0 10px 40px rgba(21,84,179,0.08);
      border:1.5px solid #E1E5EB;
    }
    .row-2 { display:flex; gap:18px; flex-wrap:wrap; }
    .row-2 > div { flex:1; min-width:200px; }
</style>
</head>
<body>

  <div class="signup-card">
   <img src="{{ asset('image/logo3.png') }}" alt="logo">
    <div style="text-align:center; margin-bottom:30px;">
      <h1 style="font-size:24px; font-weight:800; color:#16213E; margin:0 0 6px; letter-spacing:-0.01em;">SignUp</h1>
      <div style="width:64px; height:3px; background:#1554B3; border-radius:2px; margin:0 auto;"></div>
    </div>

    <form method="POST" action="/register">
      <?php echo csrf_field(); ?>

      <?php if(session('status')): ?>
        <div style="background:#ECFDF5;color:#065F46;padding:10px;border-radius:8px;margin-bottom:14px;font-weight:600;"><?php echo e(session('status')); ?></div>
      <?php endif; ?>

      <?php if($errors->any()): ?>
        <div style="background:#FEF2F2;color:#991B1B;padding:10px;border-radius:8px;margin-bottom:14px;font-weight:600;"><?php echo e($errors->first()); ?></div>
      <?php endif; ?>

      <div style="margin-bottom:18px;">
        <label class="field-label" for="name">Name</label>
        <input class="field-input" type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Full name" required>
      </div>

      <div class="row-2" style="margin-bottom:18px;">
        <div>
          <label class="field-label" for="email">Email</label>
          <input class="field-input" type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com" required>
        </div>
        <div>
          <label class="field-label" for="phone">Phone Number</label>
          <input class="field-input" type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="080X XXX XXXX" required>
        </div>
      </div>

      <div class="row-2" style="margin-bottom:30px;">
        <div>
          <label class="field-label" for="password">Password</label>
          <input class="field-input" type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <div>
          <label class="field-label" for="password_confirmation">Confirm Password</label>
          <input class="field-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
        </div>
      </div>

      <div style="text-align:center;">
        <button type="submit" class="btn-primary" style="width:220px;">SignUP</button>
      </div>

      <p style="text-align:center; font-size:13.5px; color:#6B7280; margin-top:22px;">
        Already have an account?
        <a href="login" style="color:#1554B3; font-weight:700; text-decoration:none;">Login</a>
      </p>
    </form>
  </div>

</body>
</html>
