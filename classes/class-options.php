<?php


if (!class_exists('Class_Options')) {
    
    class Class_Options {
  
        
        public function __construct(){
            add_filter('wp_login_errors', [$this, 'modify_recaptcha_message'], 9, 2);
            //add_action('wp_ajax_slider-options', [$this, 'update_slider_values']);
            //add_action('wp_ajax_no_priv_slider-options', [$this, 'update_slider_values']);
        }

        /*public function update_slider_values(){
            $value = isset($_POST['value']) ? sanitize_text_field($_POST['value']) : '';
            $font = get_option('form_color_options');
            $font['label_font'] = $value;
            self::$values['labelFont'] = $value;
            error_log(self::$values['labelFont']);
            update_option('form_color_options', $font);
            wp_send_json_success(['label_font' => $value]);
            $this->custom_css(['value' => $value]);



            
        } */

        


        public function modify_recaptcha_message($errors, $redirect_to){
            $options = get_option('custom_login_options');
            $message = isset($options['recaptcha_error_msg']) ? esc_attr($options['recaptcha_error_msg']) : "Recaptcha Not added";
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
                background-repeat: no-repeat;
                
                
            <?php endif; ?>
            <?php if(!isset($options['bg_image'])) : ?> 
                background-color: <?php echo esc_attr($options['background_color']); ?>;
            <?php endif; ?>
            
        }

        #login{
          
        <?php if (empty($options['form_background']) && !empty($colors['form_color'])) : ?>
        background-color: <?php echo esc_attr($colors['form_color']); ?>;
        <?php elseif (!empty($options['form_background'])) : ?>
            background-image: url(<?php echo esc_url($options['form_background']); ?>);
            background-size: cover;
            background-repeat: no-repeat;
            contain;
        <?php endif; ?>
        <?php if(isset($colors['border_radius'])) : ?> 
                border-radius : <?php echo esc_attr($colors['border_radius']) . 'px'; ?>
        <?php endif; ?>
          
          
        }
        

        body.login h1 a {
            <?php if(isset($options['login_logo'])) : ?> 
                background-image:url(<?php echo esc_url($options['login_logo']); ?>);
            <?php endif; ?>

        }

        body.login h1{
            margin:0;
            padding:0;
        }

      

        #loginform{
            <?php if(!empty($options['form_background'])) : ?> 
            background-color: transparent;
            <?php endif; ?>
            font-size:1.2rem;
            width:min-content;
            border:0.5vw;
            

        }
        #loginform input:not(input[type="submit"]){
            <?php if(isset($colors['Input_Font_Color'])) : ?>
                color : <? echo esc_attr($colors['Input_Font_Color']) ; ?>;
                
            
            <?php endif; ?>

        }

        #loginform label{
            <?php if(isset($colors['label_User_Login'])) : ?>
                color : <? echo esc_attr($colors['label_User_Login']) ?>;

                <?php endif; ?>
        }

        .login label{
            <?php if(isset($colors['label_font'])) : ?> 
             
            font-size: <?php echo esc_attr($colors['label_font']) . 'px'; ?>;
            <?php endif; ?>
            
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
                background-color : <?php echo esc_attr($colors['button_bg_color']) ?>;
            <?php endif; ?>
        }

        .login #backtoblog a, .login #nav a{
            <?php if(isset($colors['bottom_links'])) : ?> 
                color : <?php echo esc_attr($colors['bottom_links']) ?>; 
            <?php endif; ?>

        }
    

        /* Add more CSS rules here */
        </style>
        <?php
}
    }
}


?>