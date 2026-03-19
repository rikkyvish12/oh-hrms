<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to OHA-HRMS</title>
</head>
<body>
    <h1>Welcome to OHA-HRMS!</h1>
    
    <p>Dear {{ $user->name }},</p>
    
    <p>Welcome to OHA-HRMS (Human Resource Management System). Your account has been created successfully.</p>
    
    <h3>Login Credentials:</h3>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Temporary Password:</strong> {{ $password }}</p>
    
    <p>Please login and set your own password to secure your account.</p>
    
    <p>Login URL: <a href="{{ url('/employee/login') }}">{{ url('/employee/login') }}</a></p>
    
    <p>Set Password URL: <a href="{{ url('/employee/set-password?email=' . $user->email) }}">{{ url('/employee/set-password?email=' . $user->email) }}</a></p>
    
    <p>Thank you!</p>
    
    <p>Best regards,<br>Admin<br>OHA-HRMS</p>
</body>
</html>