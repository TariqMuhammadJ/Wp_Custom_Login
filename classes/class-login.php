<?php 

if(!class_exists('Custom_Login')){
    require_once __DIR__ . '/class-encryptor.php';
    class Custom_Login{
        private $file_path;
        private $recaptcha_keys;

        private $decryptor;

        public function __construct(){
            /*$this->recaptcha_keys = require __DIR__ . '/class-config.php'; */
            $this->include();
            $this->decryptor = new Encryptor(secret_key);
            add_action('login_enqueue_scripts', array($this, 'load_scripts'));
            add_action('login_form', array($this, 'add_recaptcha_field'),);
            add_action('login_head', array('Class_Options', 'custom_css'));
            add_filter('authenticate', array($this, 'authenticate_user'), 20, 3);
            add_filter('retrieve_password_message', array($this, 'render_email_template'), 4);
            add_filter('retrieve_password_title', array($this, 'retrieve_title'), 2);
            add_filter('wp_mail_content_type', array($this, 'mail_type'),);
          
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
            /*remove_action('login_enqueue_scripts', 'wp_print_styles', 20);
            remove_action('login_enqueue_scripts', 'wp_enqueue_scripts', 1);
            remove_action('login_enqueue_scripts', 'wp_print_scripts', 20);
            remove_action('login_head', 'wp_shake_js', 12); */

            wp_enqueue_script('modifier-js', Wp_Custom_Url . '/js/modifier.js', [], 'all');

            wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array());

            wp_enqueue_style(
                'my-login-style', // handle
                Wp_Custom_Url . '/css/custom.css', // path to your css
                array(), // dependencies
                '1.0', // version
                'all' // media
            );
            add_filter('login_headerurl', function () {
                return home_url();
            });
            add_filter('login_headertext',  function () {
                return get_bloginfo('name');
            });
        }

        


        public function add_recaptcha_field(){
            $options = get_option('second_login_options');
            $site_key = $options['recaptcha_key'] ?? "";

                if(isset($site_key)){
                error_log(esc_attr($site_key));
                echo '<div class="g-recaptcha" data-sitekey="'. esc_attr($site_key) . '"></div>';
                error_log('Rendering reCAPTCHA field');
            }
                else {
                wp_die('The site key you used is not valid');            }


            }
           
            
        public function verifyRecaptcha($recaptcha_secret, $recaptcha_response){
            $response = wp_remote_post('https://google.com/recaptcha/api/siteverify', [
                    'body' => [
                        'secret' => $recaptcha_secret,
                        'response' => $recaptcha_response,
                        'remoteip' => $_SERVER['REMOTE_ADDR'],
                    ]
                    ]);

            $response_body = wp_remote_retrieve_body($response);
                
            $result = json_decode($response_body, true);
            if(empty($result['success'])){
                error_log('false success');
                 return false;

            }
            else{
                error_log('you have successfully verified');
                return true;
            }
        }

       // I forgot to check if the site_key is initialized

        public function authenticate_user($user, $username, $password){
            $secret_key = secret_key;
            error_log("Your secret key is : {$secret_key}");
            $option = get_option('second_login_options');
            if(!empty($secret_key) && !empty($option['recaptcha_secret'])){
                if(isset($_POST['g-recaptcha-response'])){
                $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
                $key = $option['recaptcha_secret'];
                $recaptcha_secret = $this->decryptor->decrypt($key);
                error_log("Your Recaptcha secret is {$recaptcha_secret}");
                if($this->verifyRecaptcha($recaptcha_secret, $recaptcha_response)){
                     return wp_authenticate_username_password(null, $username, $password);

                }
                else {
                    return new WP_Error('recaptcha failed', __('ReCaptcha Failed', 'custom-login'));
                }

            }
            else {
                return new WP_Error('recaptcha_missing', __('Please complete the reCAPTCHA.', 'custom-login'));
            }

             if (empty($username) || empty($password)) {
               return new WP_Error('empty_credentials', __('Username or password cannot be empty.', 'custom-login'));
             }

            return wp_authenticate_username_password(null, $username, $password);
                
        }
            
      }

    

            

        }

    
}


?>