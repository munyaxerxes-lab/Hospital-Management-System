<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password | MediLink</title>

</head>

<body>

<div class="auth-page">

    <img
        src="{{ asset('images/auth/medilink-logo.png') }}"
        class="auth-logo"
        alt="MediLink">

    <div class="auth-container">

        <!-- Illustration -->
        <div class="auth-illustration">

            <img
                src="{{ asset('images/auth/forgot-password.png') }}"
                alt="Forgot Password">

        </div>

        <!-- Form -->
        <div class="auth-form-section">

            <h1 class="auth-title no-line">
                Forgot Password
            </h1>

            <form
                method="POST"
                action="{{ route('password.email') }}"
                class="auth-form">

                @csrf

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        required
                        autofocus>

                </div>

                <button
                    type="submit"
                    class="auth-button">

                    Continue

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>