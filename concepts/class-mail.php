<?php
add_filter('retrieve_password_message', array($this, 'render_email_template'), 4);
            add_filter('retrieve_password_title', array($this, 'retrieve_title'), 2);
            add_filter('wp_mail_content_type', array($this, 'mail_type'),);

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

        ?>

        // work on this later