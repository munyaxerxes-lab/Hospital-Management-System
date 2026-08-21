<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>

    <style>

        * {

            box-sizing: border-box;

        }

        body {

            margin: 0;

            background: white;

            font-family: Arial, sans-serif;

        }

        .page {

            position: relative;

            width: 317px;

            height: 222px;

            background: white;

            overflow: hidden;

        }

        /* Logo */

        .logo {

            position: absolute;

            left: 5px;

            top: 3px;

            width: 33px;

            height: 28px;

        }

        /* Image on the left */

        .illustration {

            position: absolute;

            left: 15px;

            top: 60px;

            width: 149px;

            height: 117px;

            object-fit: fill;

        }

        /* Reset password form */

        .form {

            position: absolute;

            left: 202px;

            top: 46px;

            width: 83px;

        }

        /* Title */

        h1 {

            margin: 0 0 20px 0;

            font-size: 9px;

            line-height: 10px;

            font-weight: bold;

            text-align: center;

        }

        /* Labels */

        label {

            display: block;

            margin-bottom: 3px;

            font-size: 5px;

            line-height: 6px;

            color: #111;

        }

        /* Input boxes */

        input {

            width: 83px;

            height: 17px;

            padding: 2px 4px;

            margin: 0 0 7px 0;

            border: 1px solid #8d8d8d;

            border-radius: 4px;

            outline: none;

            font-size: 7px;

            background: white;

        }

        /* Confirm button */

        button {

            display: block;

            width: 48px;

            height: 14px;

            margin: 10px auto 0 auto;

            padding: 0;

            border: none;

            border-radius: 8px;

            background: #0074e8;

            color: white;

            font-size: 6px;

            font-weight: bold;

            cursor: pointer;

        }

        /* OTP success message */

        .success-message {

            margin-bottom: 8px;

            padding: 4px;

            border: 1px solid #b7dfc5;

            border-radius: 4px;

            background: #e8f7ed;

            color: #176b36;

            font-size: 5px;

            line-height: 6px;

            text-align: center;

        }

        #passwordError {

            font-size: 5px;

            line-height: 6px;

            margin-top: -3px;

            margin-bottom: 5px;

            text-align: center;

        }

        /* Password eye icon */

        .password-wrapper {

            position: relative;

            width: 83px;

            height: 24px;

        }

        .password-wrapper input {

            position: absolute;

            left: 0;

            top: 0;

            margin: 0;

        }

        .eye-button {

            position: absolute;

            right: 3px;

            top: 8px;

            width: 10px;

            height: 10px;

            margin: 0;

            padding: 0;

            border: none;

            background: transparent;

            color: #555;

            font-size: 6px;

            line-height: 10px;

            cursor: pointer;

        }

    </style>

</head>

<body>

    <div class="page">

        <!-- Logo -->

        <img 

            class="logo" 

            src="logo2.png"

            alt="MediLink"

        >

        <!-- Illustration -->

        <img 

            class="illustration"

            src="illustration.png"

            alt="Password reset illustration"

        >

        <!-- Form -->

        <div class="form">

            <h1>Reset Password</h1>

            <!-------success message condition------>

            @if (session('status'))

                <div class="success-message">

                    {{ session('status') }}

                </div>

            @endif

            <form method="POST" action="{{ route('password.update') }}">

                @csrf

                <label for="newPassword">

                    New Password

                </label>

                <div class="password-wrapper">

                    <input 

                        id="newPassword"

                        name="password"

                        type="password"

                    >

                    <button 

                        type="button"

                        class="eye-button"

                        onclick="togglePassword('newPassword', this)"

                    >

                        👁

                    </button>

                </div>

                <label for="confirmPassword">

                    Confirm Password

                </label>

                <div class="password-wrapper">

                    <input 

                        id="confirmPassword"

                        name="password_confirmation"

                        type="password"

                    >

                    <button 

                        type="button"

                        class="eye-button"

                        onclick="togglePassword('confirmPassword', this)"

                    >

                        👁

                    </button>

                </div>

                <div id="passwordError">

                    @error('password')

                        {{ $message }}

                    @enderror

                </div>

                <button type="submit">

                    Confirm

                </button>

            </form>

        </div>

    </div>

    <script>

        const newPassword = document.getElementById('newPassword');

        const confirmPassword = document.getElementById('confirmPassword');

        const passwordError = document.getElementById('passwordError');

        confirmPassword.addEventListener('input', function () {

            if (confirmPassword.value === '') {

                passwordError.textContent = '';

                return;

            }

            if (newPassword.value !== confirmPassword.value) {

                passwordError.textContent = 'Fill well the password.';

                passwordError.style.color = 'red';

            } else {

                passwordError.textContent = 'Passwords match.';

                passwordError.style.color = 'green';

            }

        });

        function togglePassword(inputId, button) {

            const input = document.getElementById(inputId);

            if (input.type === 'password') {

                input.type = 'text';

                button.textContent = '👁';

            } else {

                input.type = 'password';

                button.textContent = '👁';

            }

        }

    </script>

</body>

</html>