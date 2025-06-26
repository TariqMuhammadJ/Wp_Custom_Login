<?php 

if(!class_exists('Custom_Login')){
    class Custom_Login{
        private $file_path;
        private $recaptcha_keys;

        public function __construct(){
            $this->recaptcha_keys = require __DIR__ . '/class-config.php';
            $this->file_path = Wp_Custom_Drive . '/css/custom.css';
            //add_action('login_init', array($this, 'load_scripts'));
            add_action('login_enqueue_scripts', array($this, 'load_scripts'));
            add_action('login_form', array($this, 'add_recaptcha_field'), 10);
            add_action('login_head', array($this, 'custom_options'));
            add_filter('authenticate', array($this, 'authenticate_user'), 20, 3);
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
            $site_key = esc_attr($this->recaptcha_keys['site_key']);
            echo '<div class="g-recaptcha" data-sitekey="'. $site_key . '"></div>';
            error_log('Rendering reCAPTCHA field');


        }


        public function custom_options(){
            $options = get_option('custom_login_options');
            $logo = !empty($options['login_logo']) ? esc_url($options['login_logo']) : Wp_Custom_Url . '/images/hopreneur.jpg';
            $clip = 'circle(50% at center)';
            echo "<style>
            .login h1 a {
            background-image:url('{$logo}');
            background-size:contain;
            width:220px;
            height:100px;
            display:block;
            background-color:black;
            clip-path:{$clip};
        }
            .g-recaptcha{
            margin-top:1vw;
            margin-bottom:1vw;
        }
            
            </style>";
        }

        public function authenticate_user($user, $username, $password){
            if(isset($_POST['g-recaptcha-response'])){
                $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);

                $response = wp_remote_post('https://google.com/recaptcha/api/siteverify', [
                    'body' => [
                        'secret' => $this->recaptcha_keys['secret_key'],
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
            
            

        }

    
}


?>