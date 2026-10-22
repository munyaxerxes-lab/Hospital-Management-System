<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediLink — Reset Password</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            background: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: #1E293B;
        }

        .reset-card {
            width: 100%;
            max-width: 900px;
            background: #FFFFFF;
            border: 1.5px solid #E2E8F0;
            border-radius: 20px;
            padding: 48px 56px;
            display: flex;
            align-items: center;
            gap: 48px;
            box-shadow: 0 10px 40px rgba(21, 84, 179, 0.08);
        }

        .illus-col {
            flex: 1;
            min-width: 280px;
            max-width: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-col {
            flex: 1.1;
            min-width: 280px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }

        .brand-text {
            font-size: 24px;
            font-weight: 800;
            font-family: 'Segoe UI', Roboto, sans-serif;
            letter-spacing: -0.02em;
        }

        .card-title {
            font-size: 24px;
            font-weight: 800;
            color: #16213E;
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .card-subtitle {
            font-size: 14px;
            color: #64748B;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .field-label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-input {
            width: 100%;
            padding: 13px 44px 13px 14px;
            border-radius: 10px;
            border: 1.5px solid #E1E5EB;
            background: #F8FAFC;
            font-size: 14.5px;
            color: #16213E;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .field-input:focus {
            outline: none;
            background: #FFFFFF;
            border-color: #1554B3;
            box-shadow: 0 0 0 3px rgba(21, 84, 179, 0.12);
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94A3B8;
            border-radius: 6px;
            transition: color 0.15s ease;
        }

        .eye-btn:hover {
            color: #1554B3;
        }

        .btn-primary {
            width: 100%;
            background: #1554B3;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 20px;
            cursor: pointer;
            transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.05s ease;
            box-shadow: 0 6px 18px rgba(21, 84, 179, 0.25);
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #0F3E85;
            box-shadow: 0 8px 22px rgba(21, 84, 179, 0.35);
        }

        .btn-primary:active {
            transform: scale(0.99);
        }

        .status-alert {
            background: #EAF9F0;
            color: #1E9C5A;
            border: 1px solid #BDE8CD;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-alert {
            background: #FFF1F2;
            color: #DC2626;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .password-hint {
            font-size: 12px;
            color: #64748B;
            margin-top: 6px;
        }

        .match-feedback {
            font-size: 12.5px;
            font-weight: 600;
            margin-top: 6px;
            min-height: 18px;
        }

        .match-feedback.valid {
            color: #1E9C5A;
        }

        .match-feedback.invalid {
            color: #DC2626;
        }

        .footer-nav {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: #64748B;
        }

        .footer-nav a {
            color: #1554B3;
            font-weight: 700;
            text-decoration: none;
            transition: text-decoration 0.15s ease;
        }

        .footer-nav a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 16px;
            }

            .reset-card {
                padding: 32px 24px;
                flex-direction: column;
                gap: 28px;
            }

            .illus-col {
                max-width: 220px;
            }
        }
    </style>
</head>
<body>

    <div class="reset-card">

        <!-- Left Illustration Column -->
        <div class="illus-col">
            <svg viewBox="0 0 420 380" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <!-- Soft shadow base -->
                <ellipse cx="210" cy="345" rx="150" ry="18" fill="#EEF2FA"/>
                <!-- Background ambient circle -->
                <circle cx="210" cy="180" r="145" fill="#EAF1FD"/>
                <circle cx="330" cy="110" r="14" fill="#1E9C5A" opacity="0.15"/>
                <circle cx="90" cy="240" r="10" fill="#1554B3" opacity="0.15"/>

                <!-- Security Shield -->
                <path d="M210 55 L310 95 C310 195 210 270 210 270 C210 270 110 195 110 95 Z"
                      fill="#FFFFFF"
                      stroke="#E1E5EB"
                      stroke-width="3"
                      filter="drop-shadow(0 10px 20px rgba(21, 84, 179, 0.08))"/>

                <path d="M210 70 L295 105 C295 185 210 250 210 250 C210 250 125 185 125 105 Z"
                      fill="#F8FAFC"
                      stroke="#1554B3"
                      stroke-width="1.5"
                      opacity="0.2"/>

                <!-- Center Lock Icon -->
                <!-- Shackle -->
                <path d="M185 160 V135 C185 121.2 196.2 110 210 110 C223.8 110 235 121.2 235 135 V160"
                      stroke="#1554B3"
                      stroke-width="9"
                      stroke-linecap="round"
                      fill="none"/>

                <!-- Lock Body -->
                <rect x="170" y="155" width="80" height="65" rx="14" fill="#1554B3"/>

                <!-- Keyhole -->
                <circle cx="210" cy="182" r="6" fill="#FFFFFF"/>
                <path d="M207 184 L205 202 H215 L213 184 Z" fill="#FFFFFF"/>

                <!-- Success Badge -->
                <circle cx="270" cy="225" r="22" fill="#1E9C5A" filter="drop-shadow(0 4px 10px rgba(30,156,90,0.3))"/>
                <path d="M260 225 L267 232 L281 218"
                      stroke="#FFFFFF"
                      stroke-width="3.2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      fill="none"/>

                <!-- Key Accent -->
                <g transform="translate(130, 240) rotate(-25)">
                    <circle cx="20" cy="20" r="14" stroke="#1E9C5A" stroke-width="4" fill="none"/>
                    <circle cx="20" cy="20" r="6" fill="#1E9C5A"/>
                    <rect x="34" y="17" width="28" height="6" rx="3" fill="#1E9C5A"/>
                    <rect x="52" y="23" width="6" height="8" rx="2" fill="#1E9C5A"/>
                    <rect x="44" y="23" width="5" height="5" rx="1.5" fill="#1E9C5A"/>
                </g>
            </svg>
        </div>

        <!-- Right Form Column -->
        <div class="form-col">

            <!-- MediLink Brand Header -->
            <div class="brand-logo">
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="crossGrad" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#1554B3"/>
                            <stop offset="1" stop-color="#1E9C5A"/>
                        </linearGradient>
                    </defs>
                    <path d="M18 4H30C31.6569 4 33 5.34315 33 7V17H43C44.6569 17 46 18.3431 46 20V28C46 29.6569 44.6569 31 43 31H33V41C33 42.6569 31.6569 44 30 44H18C16.3431 44 15 42.6569 15 41V31H5C3.34315 31 2 29.6569 2 28V20C2 18.3431 3.34315 17 5 17H15V7C15 5.34315 16.3431 4 18 4Z"
                          fill="url(#crossGrad)"/>
                    <path d="M13 24L19.5 30L35 15"
                          stroke="white"
                          stroke-width="3.4"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                <span class="brand-text">
                    <span style="color:#1554B3;">Medi</span><span style="color:#1E9C5A;">Link</span>
                </span>
            </div>

            <h1 class="card-title">Reset Password</h1>
            <p class="card-subtitle">Please create a new strong password for your account.</p>

            <!-- Status Alert -->
            @if (session('status'))
                <div class="status-alert">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Validation Errors Alert -->
            @if (isset($errors) && $errors->any())
                <div class="error-alert">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                @csrf

                <!-- New Password Field -->
                <div class="form-group">
                    <label class="field-label" for="newPassword">New Password</label>
                    <div class="password-input-wrapper">
                        <input
                            id="newPassword"
                            name="password"
                            type="password"
                            class="field-input"
                            placeholder="Enter at least 8 characters"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button
                            type="button"
                            class="eye-btn"
                            onclick="togglePasswordVisibility('newPassword', this)"
                            aria-label="Toggle password visibility"
                        >
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <div class="password-hint">Minimum 8 characters with letters and numbers.</div>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label class="field-label" for="confirmPassword">Confirm Password</label>
                    <div class="password-input-wrapper">
                        <input
                            id="confirmPassword"
                            name="password_confirmation"
                            type="password"
                            class="field-input"
                            placeholder="Re-enter your new password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button
                            type="button"
                            class="eye-btn"
                            onclick="togglePasswordVisibility('confirmPassword', this)"
                            aria-label="Toggle password visibility"
                        >
                            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <div id="matchFeedback" class="match-feedback"></div>
                </div>

                <button type="submit" class="btn-primary">
                    Update Password
                </button>

                <div class="footer-nav">
                    Remember your password?
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>

        </div>

    </div>

    <script>
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const matchFeedback = document.getElementById('matchFeedback');

        const eyeOpenSvg = `
            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        `;

        const eyeClosedSvg = `
            <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            </svg>
        `;

        function checkPasswordMatch() {
            const newPass = newPasswordInput.value;
            const confirmPass = confirmPasswordInput.value;

            if (!confirmPass) {
                matchFeedback.textContent = '';
                matchFeedback.className = 'match-feedback';
                return;
            }

            if (newPass === confirmPass) {
                matchFeedback.textContent = '\u2713 Passwords match';
                matchFeedback.className = 'match-feedback valid';
            } else {
                matchFeedback.textContent = '\u2715 Passwords do not match';
                matchFeedback.className = 'match-feedback invalid';
            }
        }

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        newPasswordInput.addEventListener('input', checkPasswordMatch);

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = eyeClosedSvg;
            } else {
                input.type = 'password';
                btn.innerHTML = eyeOpenSvg;
            }
        }
    </script>

</body>
</html>
