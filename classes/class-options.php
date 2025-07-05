<?php


if (!class_exists('Class_Options')) {
    require_once Wp_Custom_Drive . '/vendor/autoload.php';
    
    class Class_Options {
        
        public static $url;
        private $dotenv;
        
        public function __construct(){
            self::$url = 'https://sour-smoke.localsite.io';
            $this->dotenv = Dotenv\Dotenv::createImmutable(Wp_Custom_Drive);
            $this->dotenv->load();


            //$this->enqueue_ajax();
            //add_action('wp_ajax_my_login_styles', [$this, 'verify_ajax']);
            add_filter('wp_login_errors', [$this, 'modify_recaptcha_message'], 9, 2);
        }

      public static function getLive($login){
        $url = add_query_arg(array(
                'key' => $_ENV['key'],
                'url' => wp_parse_url(self::$url, PHP_URL_PATH),
                'dimension' => $_ENV['dimension'],
            ),
            'https://api.screenshotmachine.com');

        return $url;
        
      }

      public function enqueue_ajax(){
            wp_enqueue_script(
                'my_login_styles',
                Wp_Custom_Drive . '/js/custom-css.js',
                [],
                Wp_Custom_Version,
                true
            );


            wp_localize_script('my_login_styles', 'myLoginAjax', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('login_style_nonce')
            ]);
        }

        public function verify_ajax(){
            

        }
        


        public function modify_recaptcha_message($errors, $redirect_to){
            $options = get_option('custom_login_options');
            $message = isset($options['recaptcha_error_msg']) ? esc_attr($options['recaptcha_error_msg']) : "Recaptcha Missing";
            if($errors->get_error_codes()){
                if($errors->get_error_message('recaptcha_missing', 'custom-login')){
                    $errors->remove('recaptcha_missing', 'custom-login');
                    $errors->add('recaptcha_missing', __($message, 'custom-login'));

                }
            }
            return $errors;

        }

        public static function custom_css(){
        $options = get_option('custom_login_options');
        ?>
        <style type="text/css">
        body.login {
            <?php if (isset($options['background_color'])): ?>
                background-color: <?php echo esc_attr($options['background_color']); ?>;
            <?php endif; ?>
            <?php if (isset($options['bg_image'])): ?>
                background-image: url(<?php echo esc_url($options['bg_image']); ?>);
                background-size:cover
            <?php endif; ?>
            
        }
        body.login h1 a {
            <?php if(isset($options['login_logo'])) : ?> 
                background-image:url(<?php echo esc_url($options['login_logo']); ?>);
            <?php endif; ?>
        }

        #loginform {
            <?php if(isset($options['form_color'])) : ?>
                background-color:<? echo esc_attr($options['form_color']) ; ?>;

            <?php endif; ?>

         }

        /* Add more CSS rules here */
        </style>
        <?php
}
    }
}


?>