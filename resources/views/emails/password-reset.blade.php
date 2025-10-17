<p>Hello,</p>

<p>You are receiving this email because we received a password reset request for your account.</p>

<p>Click <a href="{{ route('reset', ['token' => $token, 'email' => $email]) }}">here</a> to reset your password.</p>

<p>This password reset link will expire in 60 minutes.</p>

<p>If you did not request a password reset, no further action is required.</p>
