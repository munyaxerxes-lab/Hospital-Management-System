<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('style/login-form.css') }}">
</head>

<body>
    <!--LEFT SECTION-->

    <section>

        <img src="{{ asset('image/login image.png') }}" alt="MediLink Logo" class="logo">
    </section>

    <!--RIGHT SECTION-->

    <section class="form-section">

    <div class="login-box">

        <h1>LOGIN</h1>

        <div class="heading-line"></div>

        <form action="#" method="POST">

            <div class="input-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >
            </div>


            <div class="input-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>


            <div class="forgot-password">
                <a href="#">Forget password?</a>
            </div>


            <button
                type="submit"
                class="login-button"
            >
                LOGIN
            </button>

        </form>


        <p class="signup-text">
            Don't have an account?
            <a href="#">SignUp</a>
        </p>

    </div>

</section>
</body>

</html>