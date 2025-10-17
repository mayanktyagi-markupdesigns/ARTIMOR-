<!DOCTYPE html>
<html>
<body>
    <h2>Thank you for your submission!</h2>
    <p>Hello {{ $userData['first_name'] ?? 'User' }},</p>
    <p>We’ve received your overview form successfully.</p>
    <p>Our team will get back to you shortly.</p>
    <br>
    <p>Best regards,<br>Team {{ config('app.name') }}</p>
</body>
</html>
