
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('style/main.css') }}">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MediLink - Login</title>

<body>
    <main class="login-page">

       

        <div class="login-container">

            <!-- ================= BRANDING ================= -->

            <section class="branding">

                <!-- logo-->
                <img
                    src="{{ asset('image/login_image.png') }}"
                    alt="MediLink"
                    class="logo"
                >
            </section>


            <!-- ================= LOGIN ================= -->

            <div class="login-form-container">

                <h1 class="login-title">
                    LOGIN
                </h1>

                <form
                    action=""
                    method="POST"
                    class="login-form"
                >

                    @csrf

                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('name') }}"
                            required
                            autocomplete="email"
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            
                        >

                    </div>


                    <div class="forgot-password">
                        <a href="auth.forgot-password">
                            Forget password?
                        </a>
                    </div>
                    <button
                        type="submit"
                        class="login-btn"
                    >
                    <a href="login">
                        LOGIN
                    </a> 
                    </button>

                </form>


                <p class="signup-text">
                    Dont have an account?
                    <a href="register" class="red" >
                        SignUp
                    </a>
                </p>
            </div>
        </div>

        @if ($error->any())
            <ul class="px-4 py-2 bg-red-100">
                @foreach ($errors->all() as($error) )
                <li class="my-2 text-red-500">
                    {{ $error }}
                </li>
                    
                @endforeach
            </ul>
            
        @endif
    </main>

</body>

</html>