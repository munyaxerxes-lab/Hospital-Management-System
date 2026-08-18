<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediLink — Verify Email</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 40px 20px;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verify-card {
            width: 100%;
            max-width: 500px;
            border-radius: 18px;
            padding: 40px 48px 48px;
            box-shadow: 0 10px 40px rgba(21, 84, 179, 0.08);
            border: 1.5px solid #E1E5EB;
            background: #FFFFFF;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            letter-spacing: -0.02em;
        }

        .title-section {
            text-align: center;
            margin-bottom: 28px;
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            color: #16213E;
            margin: 0 0 8px;
        }

        .underline {
            width: 64px;
            height: 3px;
            background: #1554B3;
            border-radius: 2px;
            margin: 0 auto;
        }

        .description {
            text-align: center;
            color: #6B7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .otp-input {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1.5px solid #E1E5EB;
            background: #F5F7FA;
            font-size: 24px;
            font-weight: 700;
            color: #16213E;
            text-align: center;
            letter-spacing: 8px;
        }

        .otp-input:focus {
            outline: none;
            border-color: #1554B3;
            box-shadow: 0 0 0 3px rgba(21, 84, 179, 0.12);
        }

        .btn-primary {
            width: 100%;
            margin-top: 22px;
            background: #1554B3;
            color: #FFFFFF;
            border: none;
            border-radius: 999px;
            font-weight: 700;
            font-size: 15px;
            padding: 13px 20px;
            cursor: pointer;
            transition: background .15s ease;
            box-shadow: 0 6px 16px rgba(21, 84, 179, 0.25);
        }

        .btn-primary:hover {
            background: #0F3E85;
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .error {
            display: none;
            background: #FEF2F2;
            color: #991B1B;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }

        .success {
            display: none;
            background: #ECFDF5;
            color: #065F46;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 14px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }

        .resend-section {
            text-align: center;
            margin-top: 22px;
            font-size: 13.5px;
            color: #6B7280;
        }

        .resend-btn {
            border: none;
            background: none;
            color: #1554B3;
            font-weight: 700;
            cursor: pointer;
            font-size: 13.5px;
        }

        .resend-btn:disabled {
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .timer {
            margin-top: 8px;
            font-size: 13px;
            color: #6B7280;
            text-align: center;
        }

        @media (max-width: 600px) {
            .verify-card {
                padding: 32px 24px 36px;
            }
        }
    </style>
</head>

<body>

    <div class="verify-card">

        <!-- MediLink Logo -->
        <div class="logo">

            <svg width="34" height="34" viewBox="0 0 48 48"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <defs>
                    <linearGradient
                        id="crossGrad"
                        x1="0"
                        y1="0"
                        x2="48"
                        y2="48"
                        gradientUnits="userSpaceOnUse">

                        <stop offset="0" stop-color="#1554B3"/>
                        <stop offset="1" stop-color="#1E9C5A"/>

                    </linearGradient>
                </defs>

                <path
                    d="M18 4H30C31.6569 4 33 5.34315 33 7V17H43C44.6569 17 46 18.3431 46 20V28C46 29.6569 44.6569 31 43 31H33V41C33 42.6569 31.6569 44 30 44H18C16.3431 44 15 42.6569 15 41V31H5C3.34315 31 2 29.6569 2 28V20C2 18.3431 3.34315 17 5 17H15V7C15 5.34315 16.3431 4 18 4Z"
                    fill="url(#crossGrad)"
                />

                <path
                    d="M13 24L19.5 30L35 15"
                    stroke="white"
                    stroke-width="3.4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>

            <span class="logo-text">
                <span style="color:#1554B3;">Medi</span><span style="color:#1E9C5A;">Link</span>
            </span>

        </div>


        <!-- Title -->
        <div class="title-section">

            <h1 class="title">
                Verify Your Email
            </h1>

            <div class="underline"></div>

        </div>


        <p class="description">
            We've sent a 6-digit verification code to your email address.
            Enter the code below to continue.
        </p>


        <!-- Laravel Validation Errors -->
        @if ($errors->any())

            <div class="error" style="display:block;">

                {{ $errors->first('otp') ?: $errors->first() }}

            </div>

        @endif


        <!-- Success Message -->
        @if (session('status'))

            <div class="success" style="display:block;">

                {{ session('status') }}

            </div>

        @endif


        <!-- OTP Form -->
        <form
            id="otpForm"
            method="POST"
            action="{{ route('register.verify-otp.submit') }}"
        >

            @csrf

            <input
                type="text"
                id="otp"
                name="otp"
                class="otp-input"
                placeholder="000000"
                maxlength="6"
                inputmode="numeric"
                autocomplete="one-time-code"
                required
                autofocus
            >

            <button
                type="submit"
                id="verifyButton"
                class="btn-primary"
            >
                Verify OTP
            </button>

        </form>


        <!-- Resend OTP -->
        <form
            method="POST"
            action="{{ route('register.resend-otp') }}"
            id="resendForm"
            style="display:inline;"
        >

            @csrf

            <button
                type="submit"
                id="resendButton"
                class="resend-btn"
            >
                Resend OTP
            </button>

        </form>


        <div id="timer" class="timer"></div>


    </div>


    <script>

        /*
         * Allow numbers only
         */
        const otpInput = document.getElementById('otp');

        otpInput.addEventListener('input', function () {

            this.value = this.value.replace(/\D/g, '');

        });


        /*
         * Resend OTP
         *
         * The form is submitted to Laravel.
         * Laravel generates the new OTP and sends
         * it to the user's real email address.
         */
        const resendForm = document.getElementById('resendForm');
        const resendButton = document.getElementById('resendButton');
        const timerElement = document.getElementById('timer');

        resendForm.addEventListener('submit', function () {

            /*
             * Disable the button immediately
             * so the user cannot click it multiple times.
             */
            resendButton.disabled = true;

            resendButton.textContent = 'Sending...';


            /*
             * Start the 60-second countdown.
             */
            let seconds = 60;

            timerElement.textContent =
                `You can request another code in ${seconds}s`;


            const countdown = setInterval(function () {

                seconds--;


                if (seconds > 0) {

                    timerElement.textContent =
                        `You can request another code in ${seconds}s`;

                } else {

                    clearInterval(countdown);

                    resendButton.disabled = false;

                    resendButton.textContent = 'Resend OTP';

                    timerElement.textContent = '';

                }

            }, 1000);

        });

    </script>

</body>
</html>