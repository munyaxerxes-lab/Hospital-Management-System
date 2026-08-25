<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style/main.css') }}">
    <title>Forgot Password | MediLink</title>

</head>

<body>

<div class="auth-page" style="width: 80%;
 height: 90vh;
 border: 1px solid none;
 border-radius: 12px;
 justify-self: center;
 display: flex;
 justify-contents: space-between;

 
 ">
<div style="
border: 1px solid none;
">
    <img
        src="{{ asset('image/login_image.png') }}"
        class="auth-logo"
        alt="MediLink"
        style="width: 90%;"
        >

<div class="auth-illustration">

           

</div>
</div>
    

    <div class="auth-container"
    style="
    width: 50%;
    align-items: center;
    "
    >

       
        

        <!-- Form -->
        <div 
         style="display: flex;
         justify: space-between;
         gap: 2rem;
         ">
             <a href="login"><button
                    type="submit"
                    class="auth-buttonlogin"
                    
                    >Login</button></a>

                     <a href="register"><button
                    type="submit"
                    class="auth-buttonlogin"
                    >Sign UP</button></a>
        </div>
        
        <div class="auth-form-section" 
        style="margin-top: 16rem;">

            <h1 class="auth-title no-line"
            style="color: navy;">
                Forgot Password
            </h1>

            <form
                method="POST"
                action="{{ route('password.email') }}"
                class="auth-form"
                style="
                line-height:2rem">

                @csrf

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Input you email"
                        class="form-control"
                        required
                        autofocus
                        style="
                        width:80%">

                </div>

                <button
                    type="submit"
                    class="auth-buttoncont"
                    >

                    Continue

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>