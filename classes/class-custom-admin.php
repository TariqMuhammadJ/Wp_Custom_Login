<?php

if (!class_exists('Custom_Admin')) {
    class Custom_Admin {

        public function __construct() {
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        }

        public function enqueue_admin_styles($hook) {
            if ($hook !== 'toplevel_page_Custom_Login') return;

            // Ensure this constant is defined OR replace with plugin_dir_url
            wp_enqueue_style(
                'admin-style',
                Wp_Custom_Url . '/css/admin-style.css',
                [],
                '1.0'
            );
            wp_enqueue_media();
            wp_enqueue_script(
                'custom-admin-media',
                Wp_Custom_Url . '/js/custom-admin.js',
                ['jquery'],
                '1.0',
                true
            );
        }

        public function admin_menu() {
            add_menu_page(
                'Custom Login Settings',         // Page title
                'Custom Login',                  // Menu title
                'manage_options',                // Capability
                'Custom_Login',                  // Menu slug
                array($this, 'settings_page'),   // Callback function
                'dashicons-lock',                // Icon
                81                               // Position
            );
        }

        public function register_settings() {
            register_setting('custom_login_group', 'custom_login_options');

            add_settings_section(
                'main_section',
                '', // Section title (empty if not needed)
                null,
                'custom_login'
            );

            add_settings_field(
                'login_logo',
                'Login Logo URL',
                array($this, 'field_logo'),
                'custom_login',
                'main_section'
            );
        }

        public function field_logo() {
            $options = get_option('custom_login_options');
            $logo = isset($options['login_logo']) ? esc_attr($options['login_logo']) : '';
            ?>
                <td class="login-logo-url">
                    <input type="text" id="custom_login_logo" name="custom_login_options[login_logo]" value="<?php echo $logo; ?>" class="regular-text" />
                    <div style="margin-top: 0.5vw;">
                    <input type="button" class="button select-media-button" value="Select Image" />
                    <?php if ($logo) : ?>
                            <img src="<?php echo esc_url($logo); ?>" style="max-height: 80px;">
                    <?php endif; ?>
                    </div>
                </td>
            <?php
        }


        public function settings_page() {
            ?>
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
                    <h2>Live Preview</h2>
                <iframe
                    src="<?php echo wp_login_url(); ?>"
                    width="100%"
                    height="600"
                    style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);"
                ></iframe>
                </div>
                </div>
            </div>
            <?php
        }
    }

}
?>

