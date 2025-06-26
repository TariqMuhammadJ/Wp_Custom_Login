<?php 

if(!class_exists('Custom_Login')){
    class Custom_Login{
        private $recaptcha_keys;

        public function __construct(){
            $this->recaptcha_keys = require __DIR__ . '/class-config.php';
            //add_action('login_init', array($this, 'load_scripts'));
            add_action('login_enqueue_scripts', array($this, 'load_scripts'));
            add_action('login_form', array($this, 'add_recaptcha_field'));
        }


        public function load_scripts(){
        wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array());
        wp_enqueue_style('custom-login-style',  Wp_Custom_Url . '/css/custom.css', array(), Wp_Custom_Version);
        
        $css = "
            /* Custom login styles */
            .login h1 a {
                background-image: url('" . Wp_Custom_Url . "images/hopreneur.jpg');
                background-size: contain;
                width: 220px;
                height: 100px;
                display: block;
                background-color:black;
            }

            .g-recaptcha {
                margin-top: 20px;
            }
            ";
        file_put_contents(Wp_Custom_Drive . 'css/custom.css', $css, FILE_APPEND);

                
    }

        public function add_recaptcha_field(){
            $site_key = esc_attr($this->recaptcha_keys['site_key']);
            echo '<div class="g-recaptcha" data-sitekey="'. $site_key . '"></div>';
            error_log('Rendering reCAPTCHA field');


        }
                
            
        
    }

    
}


?>