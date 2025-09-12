<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }

        .btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}!</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $user->name }},</h2>

            <p>Thank you for registering with {{ config('app.name') }}! We're excited to have you as part of our
                community.</p>

            <p>To complete your registration and start shopping, please verify your email address by clicking the button
                below:</p>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
            </div>

            <p>This verification link will expire in 60 minutes for security reasons.</p>

            <p>If you didn't create an account with {{ config('app.name') }}, please ignore this email.</p>

            <p>Happy shopping!<br>
                The {{ config('app.name') }} Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
