<?php

if (!class_exists('Custom_Admin')) {
    class Custom_Admin {
        

        public function __construct() {
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
            add_action('admin_notices', array($this, 'settings_update_notice'));
            add_filter('sanitize_option_custom_login_options', [$this,'validate_keys'], 10, 1);
            // we will work with this later add_action('phpmailer_init', array($this, 'custom_configuration'));
        }


        public function validate_keys($options){

            if(isset($options['recaptcha_key'])){
                $site_key = $options['recaptcha_key'];
                $iv = openssl_random_pseudo_bytes(iv_length);
                $encrypt = openssl_encrypt($site_key, cipher, secret_key, 0, $iv );
                $options['recaptcha_key']= base64_encode($iv . $encrypt);
                
            }

            if(isset($options['recaptcha_secret'])){
                $secret = $options['recaptcha_secret'];
                $iv = openssl_random_pseudo_bytes(iv_length);
                $encrypted = openssl_encrypt($secret, cipher, secret_key, 0, $iv);
                $options['recaptcha_secret']= base64_encode($iv . $encrypted);



            }

            return $options;
        }
        

        public function settings_update_notice(){

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
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('my-color-picker', Wp_Custom_Url . '/js/color-picker.js', ['wp-color-picker'], false, true);
             
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
            register_setting('custom_login_group', 'custom_login_options'); // ask what this does

            add_settings_section(
                'main_section',
                'Main Settings', 
                null,
                'custom_login'
            );

            $fields = [
                [
                    "id" => 'bg_image',
                    "title" => 'Background Image',
                    'type' => 'bg_image'
                ],
                [
                    'id' => 'login_logo',
                    'title' => 'Login Logo Url',
                    'type' => 'login_logo'
                ],
                [
                    'id' => 'background_color',
                    'title' => 'BG Color',
                    'type' => 'background-color'
                ],
                [
                    'id' => 'recaptcha_key',
                    'title' => 'Recaptcha Site Key',
                    'type' => 'recaptcha_key'
                ],
                [
                    'id' => 'recaptcha_secret',
                    'title' => 'Recaptcha Secret Key',
                    'type' => 'recaptcha_secret_key'
                ]
                ];

                foreach($fields as $field){
                    add_settings_field(
                        $field['id'],
                        $field['title'],
                        [$this, 'render_fields'],
                        'custom_login',
                        'main_section', 
                        $field
                    );
                }

        }

        public function render_fields($field) {
        $options = get_option('custom_login_options');
        $id = $field['id'];
        $type = $field['type'];
        $value = isset($options[$id]) ? esc_attr($options[$id]) : '';

        if ($type == 'login_logo') {
            echo "<input type='text' id='{$id}' name='custom_login_options[$id]' value='$value' class='regular-text' />";
            echo '<input type="button" class="button select-media-button" value="Select Image" />';
            if ($value) {
                echo '<img src="' . esc_url($value) . '" style="max-height: 80px; margin-left: 10px;">';
            }
        }
        elseif ($type == "bg_image") {
            echo "<input type='text' id='{$id}' name='custom_login_options[$id]' value='$value' class='regular-text' />";
            echo "<input type='button' class='button select-media-button' value='Select Image' />";
            if ($value) {
                echo '<img src="' . esc_url($value) . '" style="max-height:80px; margin-left:10px;" />';
            }
        }
        elseif($type == "background-color") {
            // Default input for background color or other fields
            echo "<input type='text' name='custom_login_options[$id]' id='accent_color' value='$value' class='my-color-field' 
            data-default-color='#ff6600' />";
        }
        else{
            echo "<input type='text' name='custom_login_options[$id]' id='{$id}' value='$value' class='regular-text' />";
        }
}

        public function settings_page() {
            global $Wp_Custom_Login;
            include $Wp_Custom_Login->locate_template('custom-settings');
        }
    }

}
?>

