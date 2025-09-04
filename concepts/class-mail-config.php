<?php 

if(!defined('ABSPATH')) exit;

if(!class_exists('MailConfig')){
    class MailConfig{
        private $host;
        private $port;
        // come back and work on this class later on
        public function custom_configuration(PHPMailer $phpmailer){
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'muhammad.tws49@gmail.com';

        }
    }
}