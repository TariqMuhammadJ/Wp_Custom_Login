<?php

if(!class_exists('Custom_Admin')){
    class Custom_Admin{

        public function __construct(){
            add_action('admin_menu', array($this, 'admin_menu'));

        }


        public function admin_menu(){
            add_menu_page(
                'Custom Login Settings',
                'Custom Login',
                'manage_options',
                'Custom_Login',
                'Custom_Login_Settings_Page'
            );
        }
    }
}




?>
