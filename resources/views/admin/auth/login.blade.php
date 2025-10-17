<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link rel="icon" href="{{ asset('assets/img/fevicon.jpg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
    :root {
        --accent1: #6A11CB;
        --accent2: #2575FC;
        --card-bg: #87CEEB;
        --input-bg: rgba(255, 255, 255, 0.96);
        --btn-bg: #FFD700;
    }

    * {
        box-sizing: border-box
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        /* background: linear-gradient(135deg,var(--accent1) 0%,var(--accent2) 100%); */
        background-image: url('{{ asset('assets/img/back.jpg') }}');
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        padding: 20px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }

    .login-box {
        width: 420px;
        background: var(--card-bg);
        border-radius: 12px;
        padding: 34px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        text-align: center;
    }

    .login-box img {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 14px;
        border: 4px solid rgba(255, 255, 255, 0.25);
    }

    .login-box h2 {
        color: #fff;
        margin: 0 0 22px;
        font-weight: 700;
    }

    .input-group {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--input-bg);
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 14px;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);
        transition: box-shadow 0.18s ease, transform 0.12s ease;
    }

    .input-group:focus-within {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .input-group .input-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #6b7280;
        background: rgba(0, 0, 0, 0.03);
        flex: 0 0 36px;
    }

    .input-group input {
        border: 0;
        background: transparent;
        outline: none;
        font-size: 15px;
        width: 100%;
        color: #222;
        padding: 6px 0;
    }

    .input-group input::placeholder {
        color: #7b7f86;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
        font-size: 14px;
        margin: 10px 0 18px;
    }

    .login-box .login-now {
        display: inline-block;
        width: 100%;
        padding: 12px;
        background: var(--btn-bg);
        color: #222;
        text-decoration: none;
        border-radius: 8px;
        font-size: 17px;
        font-weight: 700;
        border: 0;
        cursor: pointer;
        transition: background-color 0.18s ease, color 0.18s ease;
    }

    .login-box .login-now:hover {
        background: #000;
        color: #fff;
    }

    .signup {
        margin-top: 12px;
        color: #fff;
        font-size: 14px;
    }

    .signup a {
        color: #fff;
        text-decoration: underline;
    }

    @media (max-width:480px) {
        .login-box {
            width: 100%;
            padding: 22px;
        }
    }

    .footer {
        position: absolute;
        bottom: 10px;
        right: 20px;
        font-size: 14px;
        color: #0c0606ff;
    }

    .footer a {
        color: #007bff;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <img src="{{ asset('assets/img/fevicon.jpg') }}" alt="User Icon">
        <h2>Admin Login</h2>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="input-group">
                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" placeholder="Email" required autofocus>
            </div>

            <div class="input-group">
                <span class="input-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="remember-forgot">
                <label style="display:flex;align-items:center;gap:6px;color:#fff;font-weight:500;">
                    <input type="checkbox" name="remember" style="transform:scale(1.05)" /> Remember me
                </label>
            </div>

            <button type="submit" class="login-now">Login Now</button>
        </form>

        <div class="signup">
            Click here to return:&nbsp;<a href="/" style="text-decoration: underline; color: #007bff;">Back</a>
        </div>
    </div>
    <div class="footer">
        <strong>
            © 2025, made with ❤️ by
            <a href="https://www.markupdesigns.com/" target="_blank">Markup Design</a>.
        </strong>
        All rights reserved.
        <a href="{{ url('/') }}">Back</a>
    </div>
</body>

</html>