<?php
if (!class_exists('Custom_Admin')) {
    require __DIR__ . '/class-encryptor.php';
    class Custom_Admin {
        private $encryptor;

        public function __construct() {
            $this->encryptor = new Encryptor(secret_key);
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_init', array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
            add_action('admin_notices', array($this, 'settings_update_notice'));
            add_filter('pre_update_option_second_login_options', [$this,'validate_keys'], 10,  2);
            add_action('encrypted_details', [$this, 'successencrypt'], 30, 1);
            // we will work with this later add_action('phpmailer_init', array($this, 'custom_configuration'));
        }

    /*work with this to*/    
    public function successencrypt($message){
            if(empty($message)){
                return false;
            }
            else {
                ?>
            <div>
                <p><?php $message ?></p>
            </div>
            <?php
            }
        }

      
      public function validate_keys($new_value, $old_value) {
        if ($old_value === false) {
            // First time save, always encrypt
            if (!empty($new_value['recaptcha_secret'])) {
                $new_value['recaptcha_secret'] = $this->encryptor->encrypt($new_value['recaptcha_secret']);
                error_log($new_value['recaptcha_secret']);
                $this->successencrypt($message="you have successfully encrypted");
            }
            return $new_value;
        } else {
            if (
                isset($old_value['recaptcha_secret'], $new_value['recaptcha_secret']) &&
                $old_value['recaptcha_secret'] === $new_value['recaptcha_secret']
            ) {
                // Key did not change; keep old encrypted key
                $new_value['recaptcha_secret'] = $old_value['recaptcha_secret'];
            } else {
                // Key changed; encrypt new key
                if (!empty($new_value['recaptcha_secret'])) {
                    $new_value['recaptcha_secret'] = $this->encryptor->encrypt($new_value['recaptcha_secret']);
                }
            }
            return $new_value;
        }
}


        

        public function settings_update_notice(){

        }

        public function enqueue_admin_styles($hook) {
            if ($hook !== 'toplevel_page_Custom_Login') return;
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
            /*add_submenu_page(
                'Custom_Login',                // parent slug (MUST match main menu slug)
                'Secondary Settings',          // page title (shown in browser title)
                'Secondary Settings',          // menu title (shown in sidebar)
                'manage_options',              // capability
                'custom_login_secondary',      // submenu slug
                [$this, 'secondary_settings_page'] // callback function
            );
            */
           

        }

        public function register_settings() {
            register_setting('custom_login_group', 'custom_login_options'); // ask what this does
            register_setting('second_login_group', 'second_login_options');

            add_settings_section(
                'main_section',
                'Main Settings', 
                null,
                'custom_login'
            );

            add_settings_section(
                'secondary_section',         // ID
                'Secondary Settings', // Title
                null,    // Optional callback function to display description
                'custom_login',
                );
                
            
            $fields_2 = [
                
             [
                    'id' => 'recaptcha_secret',
                    'title' => 'Recaptcha Secret Key',
                    'type' => 'recaptcha_secret_key'
             ],[
                    'id' => 'recaptcha_key',
                    'title' => 'Recaptcha Site Key',
                    'type' => 'recaptcha_key'
                ]
            ];


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

                foreach($fields_2 as $field){
                    add_settings_field(
                        $field['id'],
                        $field['title'],
                        [$this, 'render_fields_2'],
                        'custom_login',
                        'secondary_section',
                        $field
                    );
                }

        }

        public function render_fields_2($field){
            $options = get_option('second_login_options');
            $id = $field['id'];
            $value = isset($options[$id]) ? esc_attr($options[$id]) : '';
            echo "<input type='text' name='second_login_options[$id]' id='{$id}' value='$value' class='regular-text' />";
        }

        public function render_fields($field) {
        $options = get_option('custom_login_options');
        //set_query_var('args',$options);
        //set_query_var('field', $field);
        global $Wp_Custom_Login;
        $Wp_Custom_Login->locate_parts('fields', $options, $field);

        
    }

        public function settings_page() {
            global $Wp_Custom_Login;
            include $Wp_Custom_Login->locate_template('custom-settings');
        }

        
    }

}
?>

