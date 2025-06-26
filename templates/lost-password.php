<!-- email-templates/lost-password.php -->

<div style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
    <h2 style="color: #0073aa;">Reset Your Password</h2>
    <p>Hello <strong>{{user_login}}</strong>,</p>
    <p>You requested a password reset for your account.</p>
    <p>
        <a href="{{reset_link}}" style="
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;">Click here to reset your password</a>
    </p>
    <p>Or copy and paste this link into your browser:</p>
    <p><a href="{{reset_link}}">{{reset_link}}</a></p>
    <hr>
    <p style="font-size: 12px;">If you didn’t request this, you can safely ignore this email.</p>
</div>
