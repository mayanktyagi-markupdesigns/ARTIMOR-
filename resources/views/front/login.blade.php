<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Artimar Login</title>
    <meta name="robots" content="noindex, nofollow" />
    <link rel="shortcut icon" href="{{ asset('assets/front/img/fivicon.png')}}" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

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
    <div class="login-container text-center">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/front/img/logo.png') }}" alt="Artimar Logo" />
            </a>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group text-start mb-3">
                <label for="email">Email ID</label><span style="color:red;">*</span>
                <input type="email" id="email" name="email" class="form-control"
                       placeholder="e.g. john@artimar.com" value="{{ old('email') }}" />
                @error('email')
                    <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group text-start mb-2">
                <label for="password">Password</label><span style="color:red;">*</span>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="Enter Your Password"  />
                @error('password')
                    <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                @enderror
                <a href="{{route('forgot.password')}}" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="text-center my-5">
                <button type="submit" class="btn btn-dark btn-primary px-4">Login</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    <!-- SweetAlert2 Popup -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
        @endif

        @if($errors->any() && !session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33',
            });
        @endif
    </script>
</body>
</html>
