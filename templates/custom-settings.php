<div class="admin-wrap">
    <div class="welcome-section">
        <h1>Custom Login Settings</h1>
        <p>Hey, how are all of you guys doing?</p>
    </div>

    <div class="main-section-bar">
        <div class="settings-bar">
            <form method="post" action="options.php">
                <?php
                settings_fields('custom_login_group');
                do_settings_sections('custom_login');
                submit_button();
                ?>
            </form>
        </div>
        <div class="iframe-bar">
            <iframe
                src="<?php echo wp_login_url(); ?>"
                width="100%"
                height="600"
                style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"></iframe>
        </div>
    </div>
</div>