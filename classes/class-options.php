<?php


if (!class_exists('Class_Options')) {
    
    class Class_Options {
        
       
        
        public function __construct(){
          
            add_filter('wp_login_errors', [$this, 'modify_recaptcha_message'], 9, 2);
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
        $colors = get_option('form_color_options');
        ?>
        <style type="text/css">
        body.login {
            <?php if (isset($options['bg_image'])): ?>
                background-image: url(<?php echo esc_url($options['bg_image']); ?>);
                background-size:cover;
                
                
            <?php endif; ?>
            <?php if(!isset($options['bg_image'])) : ?> 
                background-color: <?php echo esc_attr($options['background_color']); ?>;
            <?php endif; ?>
            
        }

        #login{
            <?php if(isset($colors['background_color'])) : ?> 
                background-color : <?php echo esc_attr($colors['background_color']) ?>;

            <?php endif; ?>
        }
        

        body.login h1 a {
            <?php if(isset($options['login_logo'])) : ?> 
                background-image:url(<?php echo esc_url($options['login_logo']); ?>);
            <?php endif; ?>

        }

        body.login h1{
            background-color: black;
            margin:0;
            padding:0;
        }


        #loginform{
            <?php if(isset($colors['form_color'])) : ?>
                background-color:<? echo esc_attr($colors['form_color']) ; ?>;

            <?php endif; ?>
            font-size:1.2rem;
            width:min-content;
            border:0.5vw;
            

            }
        #loginform input:not(input[type="submit"]){
            <?php if(isset($colors['Input_Font_Color'])) : ?>
                color : <? echo esc_attr($colors['Input_Font_Color']) ; ?>;
                
            
            <? endif; ?>

        }

        #loginform label{
            <?php if(isset($colors['label_User_Login'])) : ?>
                color : <? echo esc_attr($colors['label_User_Login']) ?>;

                <? endif; ?>
        }

        #login #login-message{
            background-color:green;
            color:white;
            border-left: 2px solid white;
        }

        #login #login_error{
            background-color:red;
            color:white;
            border-left: 2px solid orange;
        }

        #loginform input[type="submit"]{
            <?php if(isset($colors['button_bg_color'])) : ?>
                background-color : <? echo esc_attr($colors['button_bg_color']) ?>;
            <? endif; ?>
        }

        .login #backtoblog a, .login #nav a{
            <?php if(isset($colors['bottom_links'])) : ?> 
                color : <?php echo esc_attr($colors['bottom_links']) ?>; 
            <? endif; ?>

        }
    

        /* Add more CSS rules here */
        </style>
        <?php
}
    }
}


?>