<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Artimar Set New Password</title>
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" href="{{ asset('assets/front/img/fivicon.png')}}" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/login.css')}}" />
    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/login.css')}}" />
    <style>
    body {
        position: relative;
        margin: 0;
        padding: 0;
        font-family: 'Ubuntu', sans-serif;
        background: url('{{ asset('assets/front/img/backgroud.png')}}') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }    
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/front/img/logo.png') }}" alt="Artimar Logo" />
            </a>
        </div>
        <h3>Set New Password</h3>
        <p>Must Be At Least 8 Characters.</p>
        @if($errors->any())
        <div class="alert alert-danger">{!! implode('<br>', $errors->all()) !!}</div>
        @endif
        <form method="POST" action="{{ route('reset.password.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">
            <input type="hidden" name="otp_verified" value="{{ session('otp_verified') === true ? 'true' : 'false' }}">           

            <div class="form-group text-start mb-3 position-relative">
                <label for="password">Password</label><span style="color:red;">*</span>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Enter Your Password" required />
                <i class="fas fa-eye password-toggle" id="togglePassword" onclick="togglePassword('password')"></i>
            </div>

            <div class="form-group text-start mb-3 position-relative">
                <label for="password_confirmation">Confirm Password</label><span style="color:red;">*</span>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    placeholder="Confirm Password" required />
                <i class="fas fa-eye password-toggle" id="togglePassword_confirmation"
                    onclick="togglePassword('password_confirmation')"></i>
            </div>

            <div class="text-center my-5 d-flex align-items-center justify-content-center gap-4">
                <button type="submit" class="btn btn-dark btn-primary px-4">Reset Password</button>
            </div>
        </form>
        <a href="{{ route('login') }}" class="back-link">&lt;&lt; Back To Log In</a>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(`toggle${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
    </script>
</body>
</html>