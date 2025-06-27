<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Email</title>
</head>
<body>
  <h2>Welcome, {{ $name }}!</h2>

  <p>Your account has been created successfully as a <strong>{{ ucfirst($role) }}</strong>. You can now log in with the following credentials:</p>

  <p><strong>Email:</strong> {{ $email }}</p>
  <p><strong>Password:</strong> {{ $password }}</p>

  <p>Please change your password after your first login.</p>

  <p>Thank you!</p>
</body>
</html>