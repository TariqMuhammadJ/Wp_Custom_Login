<?php 
/*
   Plugin Name: Custom Login
   Plugin URI : -
   Description: A custom login plugin for managing wordpress login pages
   Version    : 1.0
   Author     : Muhammad Tariq
   Author URI: http://www.wpexpertdeveloper.com/
   License: GPLv2 or later
   Text Domain: custom-login
 
 */


 /*add_action('plugin_loadeds', 'custom-login-init');

 function custom_login_init(){
    if(!class_exists('Wp_Custom_Login')){
        exit;
    }
    else{
        new Wp_Custom_Login();
    }
 }
*/

if(!defined('ABSPATH')){
    exit;
}

if(!class_exists('Wp_Custom_Login')){
    class Wp_Custom_Login{
    private static $instance;
    

    public static function instance(){
        if(!isset(self::$instance) && !(self::$instance instanceof Wp_Custom_Login)){
            self::$instance = new Wp_Custom_Login();
            self::$instance->setup_constants();
            self::$instance->includes();
            self::$instance->admin_settings = new Custom_Admin();
            self::$instance->login_page = new Custom_Login();
            self::$instance->options = new Class_Options();
            //self::$instance->styles = add_action('login_head', [self::$instance, 'main_style']);
        }

        return self::$instance;
    }

    /*public function main_style(){
        wp_enqueue_style('login_style', Wp_Custom_Drive . '/classes/class-options-css.php');

    }*/
   public function locate_parts($slug, ...$args){
    // $args is now an array of all extra arguments
    foreach ($args as $index => $arg) {
        // Optionally extract arrays if needed
        if (is_array($arg)) {
            extract($arg);
        }
    }

    $path = Wp_Custom_Drive . "/parts/$slug.php";

    if (file_exists($path)) {
        return $path;
    } else {
        return false;
    }
}

    public function locate_template($slug){
        $path = Wp_Custom_Drive . "/templates/{$slug}.php";
        if(file_exists($path)){
            return $path;
        }
        else{
            return false;
        }
    }

    public function locateFile($slug){
        $path = Wp_Custom_Drive . "/classes/class-{$slug}.php";
        if(file_exists($path)){
            return $path;
        }
        else {
            return false;
        }
    }


    public function setup_constants(){
        if(!defined('secret_key')){
           $key = get_option('SECRET_RECAPTCHA_KEY');
           if (!$key) {
                $key = bin2hex(random_bytes(32));
                add_option('SECRET_RECAPTCHA_KEY', $key, '', 'no');
            }
            define('secret_key', $key);
        }
        if(!defined('Wp_Custom_Version')){
            define('Wp_Custom_Version', '1.0');
        }

        if (!defined('Wp_Custom_Drive')){
            define('Wp_Custom_Drive', plugin_dir_path(__FILE__));
            // used for loading files not on the server

        }

        if(!defined('Wp_Custom_Url')){
            define('Wp_Custom_Url', plugin_dir_url(__FILE__));
            // used for loading scripts and styles
        }

    }

    public function includes(){
        require_once Wp_Custom_Drive . '/classes/class-login.php';
        require_once Wp_Custom_Drive . '/classes/class-custom-admin.php';
        require_once Wp_Custom_Drive . '/classes/class-options.php';
    }
    
    public function load_text_domain(){


    }
}

//add_action('plugins_loaded', array('Wp_Custom_Login', 'instance'));

function Wp_Custom_Login(){
    global $Wp_Custom_Login;
    $Wp_Custom_Login = Wp_Custom_Login::instance();

}

register_deactivation_hook(__FILE__, 'my_plugin_on_deactivate');

function my_plugin_on_deactivate() {
    wp_clear_scheduled_hook('my_plugin_cron_event');
}


register_uninstall_hook(__FILE__, 'plugin_on_delete');

function plugin_on_delete(){
    delete_option('custom_login_options');
    delete_option('second_login_options');
    delete_option('form_color_options');
    delete_option('text_error_options');

}


Wp_Custom_Login();

}



?>