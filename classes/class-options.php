<?php 
if (!class_exists('Class_Options')) {
    class Class_Options {

        public static function custom_options() {

            $options = get_option('custom_login_options');
            $logo = !empty($options['login_logo']) 
                ? esc_url($options['login_logo']) 
                : Wp_Custom_Url . '/images/hopreneur.jpg';

            $bg_color = !empty($options['background_color']) 
                ? sanitize_hex_color($options['background_color']) 
                : '#000000';

            $clip = 'circle(50% at center)';
            // use objects and styles for better reference
            

            echo "<style>
                body.login {
                    font-family: 'Segoe UI', Tahoma, sans-serif;
                    background-color: $bg_color;
                }

                .login h1 a {
                    background-image: url('$logo');
                    background-size: contain;
                    width: 220px;
                    height: 100px;
                    display: block;
                    background-color: black;
                    clip-path: $clip;
                }

                .login form {
                    background: #ffffff;
                    border: 1px solid #ddd;
                    padding: 26px 24px;
                    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
                    border-radius: 12px;
                    max-width: 360px;
                    margin: 0 auto;
                }

                .login form .input, 
                .login input[type='text'],
                .login input[type='password'] {
                    font-size: 16px;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    width: 100%;
                    margin-top: 5px;
                    box-sizing: border-box;
                }

                .login label {
                    font-weight: 600;
                    color: #333;
                }

                .wp-core-ui .button-primary {
                    background: #0073aa;
                    border: none;
                    border-radius: 6px;
                    font-size: 16px;
                    padding: 10px;
                    width: 100%;
                    transition: background 0.3s ease;
                }

                .wp-core-ui .button-primary:hover {
                    background: #006799;
                }

                #nav, #backtoblog {
                    text-align: center;
                    margin-top: 20px;
                }

                #nav a, #backtoblog a {
                    color: #ffffff !important;
                    text-decoration: underline;
                    font-weight: 500;
                }

                .login .message,
                .login .success,
                .login .error {
                    border-left: 4px solid #0073aa;
                    padding: 12px;
                    margin-bottom: 20px;
                    border-radius: 6px;
                }

                .login #login h1 {
                    margin-bottom: 0;
                }
            </style>";
        }
    }


}
?>
