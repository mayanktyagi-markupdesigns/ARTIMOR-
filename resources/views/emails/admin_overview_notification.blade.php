<!DOCTYPE html>
<html>
<body>
    <h2>New Overview Form Submission</h2>
    <p><strong>Name:</strong> {{ $userData['first_name'] ?? '' }} {{ $userData['last_name'] ?? '' }}</p>
    <p><strong>Email:</strong> {{ $userData['email'] ?? '' }}</p>
    <p><strong>Phone:</strong> {{ $userData['phone_number'] ?? '' }}</p>
    <p><strong>Submitted At:</strong> {{ now()->format('d M Y h:i A') }}</p>
</body>
</html>
