<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verification Code</title>
</head>
<body>
    <h2>Hello {{ $user->username ?? 'User' }}</h2>

    <p>Your verification code is:</p>

    <h1>{{ $code }}</h1>

    <p>This code will expire in a few minutes.</p>
</body>
</html>
