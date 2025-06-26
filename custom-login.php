<?php 
/*
   Plugin Name: Custom Login
   Plugin URI : -
   Description: A custom login plugin for managing wordpress login pages
   Version    : 1.0
   Author     : Rakhitha Nimesh
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
        }

        return self::$instance;
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


    public function setup_constants(){
        //global $template;
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

        //$template->set_plugin_path(Wp_Custom_Drive);

    }

    public function includes(){
        require_once Wp_Custom_Drive . '/classes/class-login.php';
        require_once Wp_Custom_Drive . '/classes/class-custom-admin.php';
    }
    
    public function load_text_domain(){


    }
}

//add_action('plugins_loaded', array('Wp_Custom_Login', 'instance'));

function Wp_Custom_Login(){
    global $Wp_Custom_Login;
    $Wp_Custom_Login = Wp_Custom_Login::instance();

}

Wp_Custom_Login();

}



?>