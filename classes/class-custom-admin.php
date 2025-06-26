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
                array($this, 'settings_page'),
                'dashicons-lock',
                81,
            );
        }

        public function settings_page(){
            ?>

            <div class="wrap">
                <h1>Custom Login Settings</h1>
                <p>Hey how are all of you guys doing</p>
                
            </div>

            <?
        }
    }
}




?>
