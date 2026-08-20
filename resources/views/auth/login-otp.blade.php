<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MediLink — Verify Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .otp-card {
            width: 100%;
            max-width: 450px;
            border: 1.5px solid #F6C9CE;
            border-radius: 18px;
            padding: 45px;
            box-shadow: 0 10px 40px rgba(21, 84, 179, 0.06);
            text-align: center;
        }

        h1 {
            font-size: 26px;
            font-weight: 800;
            color: #16213E;
            margin-bottom: 8px;
        }

        .description {
            color: #6B7280;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .otp-input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1.5px solid #E1E5EB;
            background: #F5F7FA;
            font-size: 24px;
            text-align: center;
            letter-spacing: 8px;
            color: #16213E;
        }

        .otp-input:focus {
            outline: none;
            border-color: #1554B3;
            box-shadow: 0 0 0 3px rgba(21, 84, 179, 0.12);
        }

        .btn-primary {
            width: 100%;
            background: #1554B3;
            color: #fff;
            border: none;
            border-radius: 999px;
            font-weight: 700;
            font-size: 15px;
            padding: 13px 20px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background: #0F3E85;
        }

        .error {
            background: #FEF2F2;
            color: #991B1B;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 14px;
        }

        .success {
            background: #ECFDF5;
            color: #065F46;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 14px;
        }

        .resend-text {
            margin-top: 20px;
            color: #6B7280;
            font-size: 13.5px;
        }

        .resend-button {
            background: none;
            border: none;
            padding: 0;
            margin-left: 5px;
            color: #1554B3;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
        }

        .resend-button:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="otp-card">

    <h1>VERIFY LOGIN</h1>

    <p class="description">
        We have sent a 6-digit verification code to your email address.
        Enter the code below to continue.
    </p>


    {{-- COUNTDOWN --}}

    <div id="countdown" style="
        color:#1554B3;
        font-size:14px;
        font-weight:700;
        margin-bottom:20px;
    ">
        OTP expires in: 01:00
    </div>


    {{-- SUCCESS MESSAGE --}}

    @if (session('status'))
        <div class="success">
            {{ session('status') }}
        </div>
    @endif


    {{-- ERROR MESSAGE --}}

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif


    {{-- VERIFY OTP FORM --}}

    <form method="POST" action="{{ route('login.verify-otp.submit') }}">

        @csrf

        <input
            type="text"
            name="otp"
            class="otp-input"
            maxlength="6"
            minlength="6"
            inputmode="numeric"
            pattern="[0-9]{6}"
            placeholder="000000"
            required
            autofocus
        >

        <button type="submit" class="btn-primary">
            VERIFY OTP
        </button>

    </form>


    {{-- RESEND OTP --}}

    <div class="resend-text">

        Didn't receive the code?

        <form
            method="POST"
            action="{{ route('login.resend-otp') }}"
            style="display:inline;"
        >

            @csrf

            <button type="submit" class="resend-button">
                Resend OTP
            </button>

        </form>

    </div>

</div>


<script>

    // OTP expiration time: 1 minute
    let timeLeft = 1 * 60;

    const countdown = document.getElementById('countdown');

    const timer = setInterval(function () {

        const minutes = Math.floor(timeLeft / 60);

        const seconds = timeLeft % 60;

        const formattedSeconds = seconds < 10
            ? '0' + seconds
            : seconds;

        countdown.textContent =
            'OTP expires in: ' +
            minutes + ':' +
            formattedSeconds;


        // When timer reaches zero
        if (timeLeft <= 0) {

            clearInterval(timer);

            countdown.textContent = 'OTP expired';

            countdown.style.color = '#DC2626';

        }

        timeLeft--;

    }, 1000);

</script>

</body>
</html>