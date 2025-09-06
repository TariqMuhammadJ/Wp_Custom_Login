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
            // do_action('encrypted details)
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
                //error_log($new_value['recaptcha_secret']);
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

            wp_enqueue_script(
                'custom_css',
                Wp_Custom_Url . '/js/custom-css.js',
                [],
                Wp_Custom_Version,
                true
            );
              wp_enqueue_script(
                'slider-options',
                Wp_Custom_Url . '/js/input-slider.js',
                [],
                Wp_Custom_Version,
                true
            );

            /*wp_localize_script(
                'slider-options', 'sliderAjax', array(
                    'ajax_url' => admin_url('admin-ajax.php')
                )
                ); */

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
            register_setting('second_login_group', 'second_login_options');
            register_setting('form_color', 'form_color_options');
            register_setting('text_errors', 'text_error_options');

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
            add_settings_section(
                'third_section',
                'third settings',
                null,
                'custom_login'
            );

            add_settings_section(
                'fourth_section',
                'Fourth settings',
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
                    'id' => 'form_background',
                    'title' => 'Form Background Image',
                    'type' => 'form_bg'
                ]
            ];

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

            
                $fields_3 = [
                    [
                    'id' => 'background_color',
                    'title' => 'BG Color',
                    'type' => 'background-color'
                ],
                [
                    'id' => 'form_color',
                    'title' => 'Form Color',
                    'type' => 'form_color'
                ],
               
                [
                    'id' => 'Input_Font_Color',
                    'title' => 'Input Font',
                    'type' => 'Input-Font-Color'
                ],
                
                [
                    'id' => 'label_User_Login',
                    'title' => 'Username Label', 
                    'type' => 'Label-User-Login'
                ], 
                [
                    'id' => 'button_bg_color',
                    'title' => 'Button Background Color',
                    'type' => 'Button-Bg-Color'
                ], 
                [
                    'id' => 'bottom_links', 
                    'title' => 'Bottom Links',
                    'type' => 'Bottom-Links'
                ], 
                [
                    'id' => 'label_font',
                    'title' => 'Font Size',
                    'type' => 'font_size'
                ],
                [
                    'id' => 'border_radius',
                    'title' => 'Form Border Radius',
                    'type' => 'form_border'
                ]
                ];



                $fields_4 = [
                        [
                        'id' => 'recaptcha_error_msg',
                        'title' => 'recaptcha message',
                        'type' => 'recaptcha_message'
                    ],
                    [
                        'id' => 'recaptcha_failed_msg',
                        'title' => 'reCAPTCHA Failed Message',
                        'type' => 'recaptcha_message'

                    ],
                    [
                        'id' => 'username_pass_msg',
                        'title' => 'Username Pass Empty',
                        'type' => 'recaptcha_msg'
                    ]
                ];



                foreach($fields as $field){
                    $field['option_name'] = 'custom_login_options';
                    add_settings_field(
                        $field['id'],
                        '',
                        [$this, 'render_fields'],
                        'custom_login',
                        'main_section', 
                        $field
                    );
                }

                foreach($fields_2 as $field){
                    $field['option_name'] = 'second_login_options';
                    add_settings_field(
                        $field['id'],
                        $field['title'],
                        [$this, 'render_fields'],
                        'custom_login',
                        'secondary_section',
                        $field
                    );
                }

                foreach($fields_3 as $field){
                    $field['option_name'] = 'form_color_options';
                    add_settings_field(
                        $field['id'],
                        '',
                        [$this, 'render_fields'],
                        'custom_login',
                        'third_section',
                        $field

                    );

                }
                foreach($fields_4 as $field){
                    $field['option_name'] = 'text_error_options';
                    add_settings_field(
                        $field['id'],
                        '',
                        [$this, 'render_fields'],
                        'custom_login',
                        'fourth_section',
                        $field
                    );
                }

        }

       
        public function render_fields($field) {
        if(!isset($field) && !isset($field['option_name'])){
            echo '<p class="error">Option not set</p>';
            return;

        }

        $options = get_option($field['option_name']);
        global $Wp_Custom_Login;
        require $Wp_Custom_Login->locate_parts('fields',$options ,  $field);

        
    }

        public function settings_page() {
            global $Wp_Custom_Login;
            $url = add_query_arg(
            [
                'page' => 'Custom_Login',
                'tab'  => 'advanced'
            ],
            admin_url()
        );
            include $Wp_Custom_Login->locate_template('custom-settings');
        }

        
    }

}
?>

