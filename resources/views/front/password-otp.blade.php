<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Artimar Password Reset</title>
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/fivicon.png" />

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
    body{
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
        <h3>Password Reset</h3>
        <p>We Sent A Code To <span style="color: #ff0000;">{{ session('email') ?? old('email') }}</span></p>
        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">{!! implode('<br>', $errors->all()) !!}</div>
        @endif
        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">
            <input type="hidden" name="otp" id="otp">
            <div class="form-group text-center">
                <div class="code-input">
                    <input type="text" maxlength="1" class="otp-digit" required />
                    <input type="text" maxlength="1" class="otp-digit" required />
                    <input type="text" maxlength="1" class="otp-digit" required />
                    <input type="text" maxlength="1" class="otp-digit" required />
                </div>
            </div>

            <div class="text-center my-5 d-flex align-items-center justify-content-center gap-4">
                <button type="submit" class="btn btn-dark btn-primary px-4">Continue</button>
            </div>
        </form>
        <a href="#" class="resend-link">Didn't Receive The Email? Click To Resend</a>
        <a href="{{ route('login') }}" class="back-link">&lt;&lt; Back To Log In</a>
    </div>

    <!-- Scripts -->
    <script>
    const inputs = document.querySelectorAll('.otp-digit');
    const hiddenOtp = document.getElementById('otp');

    document.querySelector('form').addEventListener('submit', function(e) {
        let otp = '';
        inputs.forEach(input => otp += input.value);
        hiddenOtp.value = otp;
    });

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
    </script>
</body>
</html>