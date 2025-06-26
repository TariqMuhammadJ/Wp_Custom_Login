<div class="custom-login-form">
    <h2>Welcome Back 👋</h2>
    <p class="subtitle">Please log in to your account</p>
    <form method="post" action="">
        <div class="custom-login-field">
            <label for="custom-username">Username or Email</label>
            <input type="text" id="custom-username" name="custom-username" required />
        </div>

        <div class="custom-pass-field">
            <label for="custom-password">Password</label>
            <input type="password" id="custom-password" name="custom-password" required />
        </div>

        <div class="custom-field checkbox">
            <label>
                <input type="checkbox" name="custom_remember" />
                Remember me
            </label>
        </div>

        <button type="submit" name="custom_login_submit">Log In</button>
        <p class="forgot-link"><a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a></p>
    </form>
</div>
