<?php 

if(!class_exists('Custom_Login')){
    class Custom_Login{
        private $file_path;
        private $recaptcha_keys;

        private $decryptor;

        public function __construct(){
            $this->recaptcha_keys = require __DIR__ . '/class-config.php';
            $this->include();
            $this->decryptor = new Encryptor(secret_key);
            require_once $Wp_Custom_Login->locateFile('encryptor');
            //add_action('login_init', array($this, 'load_scripts'));
            add_action('login_enqueue_scripts', array($this, 'load_scripts'));
            add_action('login_form', array($this, 'add_recaptcha_field'), 10);
            add_action('login_head', array('Class_Options', 'custom_options'));
            add_filter('authenticate', array($this, 'authenticate_user'), 20, 3);
            add_filter('retrieve_password_message', array($this, 'render_email_template'), 30, 4);
            add_filter('retrieve_password_title', array($this, 'retrieve_title'), 35, 2);
            add_filter('wp_mail_content_type', array($this, 'mail_type'), 31);
        }

        public function render_email_template($message, $key, $user_login, $user_data){
            global $Wp_Custom_Login;
            $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
            $template = $Wp_Custom_Login->locate_template('lost-password');
            if(!file_exists($template)){
                wp_die("Sorry no template found", "For the Path");
            }

            $vars = [
                'reset_link' => $reset_link,
                'user_login' => $user_login
                
            ];

            ob_start();

            $placeholders = [];
            foreach($vars as $var => $value){
                $placeholders["{{{$var}}}"] = $value;

            }
            include $template;
            $html = ob_get_clean();
            add_filter('wp_mail_content_type', function (){
                return 'text/plain';
            });

        

        }

        public function mail_type(){
            return 'text/html';
        }

        public function retrieve_title($title, $user_login){
             return '🔐 Reset Your Password - ' . get_bloginfo('name');
        }

        
        public function include(){
            require_once plugin_dir_path(__FILE__) . 'class-options.php';
        }

        public function load_scripts(){
        wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array());
        wp_enqueue_style('custom-login-style',  Wp_Custom_Url . '/css/custom.css', array(), Wp_Custom_Version);
        add_filter('login_headerurl', function () {
            return home_url();
        } );
        add_filter('login_headertext',  function (){
            return get_bloginfo('name');
        });

                
    }

        


        public function add_recaptcha_field(){
            $option = get_option('custom_login_options');
            $site_key = $option['recaptcha_key'];
            if(!empty($site_key)){
                if(isset($site_key)){
                error_log(esc_attr($site_key));
                echo '<div class="g-recaptcha" data-sitekey="'. esc_attr($site_key) . '"></div>';
                error_log('Rendering reCAPTCHA field');
            }
                else {
                wp_die('The site key you used is not valid');            }


            }
            else {
                return;
            }
            }
            

       

        public function authenticate_user($user, $username, $password){
            $secret_key = get_option('SECRET_RECAPTCHA_KEY');
            $secret = $this->decryptor->decrypt($secret_key);
            if(!empty($secret)){
                if(isset($_POST['g-recaptcha-response'])){
                $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
                $option = get_option('custom_login_options');
                $secret_key = $option['recaptcha_secret'];
                $value = base64_decode($secret_key);
                $iv = substr($value, 0 , iv_length);
                $encrypted_data = substr($value, iv_length);
                $decrypted_key = openssl_decrypt($encrypted_data, cipher, secret_key, 0, $iv);

                $response = wp_remote_post('https://google.com/recaptcha/api/siteverify', [
                    'body' => [
                        'secret' => $decrypted_key,
                        'response' => $recaptcha_response,
                        'remoteip' => $_SERVER['REMOTE_ADDR'],
                    ]
                    ]);

                $response_body = wp_remote_retrieve_body($response);
                $result = json_decode($response_body, true);
                if(empty($result['success'])){
                    return new Wp_Error('recaptcha failed', __('ReCaptcha Failed', 'custom-login'));
                }

            }
            else{
                return new WP_Error('recaptcha_missing', __('Please complete the reCAPTCHA.', 'custom-login'));
            }

             if (empty($username) || empty($password)) {
               return new WP_Error('empty_credentials', __('Username or password cannot be empty.', 'custom-login'));
             }

            return wp_authenticate_username_password(null, $username, $password);
                
        }
         else {
            return wp_authenticate_username_password(null, $username, $password);
         }
            
            }

            

        }

    
}


?>