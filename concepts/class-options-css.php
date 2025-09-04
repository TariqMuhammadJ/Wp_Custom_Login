<?php
/**
 * Dynamic CSS file to style the login page.
 * This file outputs CSS with variables from options.
 */
header("Content-Type: text/css");

$options = get_option('custom_login_options');

$bg_color = !empty($options['background_color']) ? sanitize_hex_color($options['background_color']) : '#000';
$bg_image = !empty($options['bg_image']) ? esc_url($options['bg_image']) : '';
$logo     = !empty($options['login_logo']) ? esc_url($options['login_logo']) : '';

$options = get_option('custom_login_options');

?>

body.login {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background-color: <?= $bg_color ?>;
    <?php if ($bg_image): ?>
    background-image: url('<?= $bg_image ?>');
    background-size: cover;
    background-repeat: no-repeat;
    <?php endif; ?>
}

.login h1 a {
    background-image: url('<?= $logo ?>');
    background-size: contain;
    width: 220px;
    height: 100px;
}

.login form {
    background: #fff;
    border: 1px solid #ddd;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}


<?

?>