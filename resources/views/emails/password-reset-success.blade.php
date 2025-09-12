<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset Successful - {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .success-icon { font-size: 3rem; color: #28a745; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
        .security-tips { background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Successful!</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="success-icon">✓</div>
            </div>
            
            <h2>Hello {{ $user->name }},</h2>
            
            <p>Your password has been successfully reset for your {{ config('app.name') }} account.</p>
            
            <p><strong>Reset Details:</strong></p>
            <ul>
                <li>Email: {{ $user->email }}</li>
                <li>Date: {{ now()->format('F j, Y') }}</li>
                <li>Time: {{ now()->format('g:i A') }}</li>
            </ul>
            
            <div class="security-tips">
                <strong>Security Tips:</strong>
                <ul>
                    <li>Keep your password secure and don't share it with anyone</li>
                    <li>Use a strong, unique password for your account</li>
                    <li>If you didn't reset your password, contact us immediately</li>
                </ul>
            </div>
            
            <p>You can now sign in to your account using your new password.</p>
            
            <p>If you have any questions or concerns, please don't hesitate to contact our support team.</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>