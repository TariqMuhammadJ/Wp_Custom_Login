<?php 
if (!class_exists('Class_Options')) {
    class Class_Options {
        


        public function __construct(){
            $this->enqueue_ajax();
            add_action('wp_ajax_my_login_styles', [$this, 'verify_ajax']);
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
            <?php endif; ?>
            background-size:cover;
        }
        body.login h1 a {
            <?php if(isset($options['login_logo'])) : ?> 
                background-image:url(<?php echo esc_url($options['login_logo']); ?>);
            <?php endif; ?>
        }
        /* Add more CSS rules here */
        </style>
        <?php
}
    }
}


?>