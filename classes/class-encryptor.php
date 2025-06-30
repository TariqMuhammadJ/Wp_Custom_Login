<?php 
if(!defined('ABSPATH')) exit;

if(!class_exists('Encryptor')){
    require_once $Wp_Custom_Login->locateFile("encrypt");
    class Encryptor implements EncryptorInterface{
        private string $key;
        private string $method;
        private int $ivLength;

        public function __construct(string $key, string $method = 'AES-256-CBC'){
            $this->key = $key;
            $this->method = $method;
            $this->ivLength = openssl_cipher_iv_length($method);
        }

        public function encrypt(string $data) : string{
            $iv = openssl_random_pseudo_bytes($this->ivLength);
            $encrypted = openssl_encrypt($data, $this->method, $this->key, 0, $iv);

            return base64_encode($iv . $encrypted);
        }

        public function decrypt(string $data) : string {
            $decoded = base64_decode($data);
            $iv = substr($decoded, 0, $this->ivLength);
            $encrypted_data = substr($decoded, $this->ivLength);
            $decrypted = openssl_decrypt($encrypted_data, $this->method, $this->key, 0, $iv);
            return $decrypted;
        }

    }
}


?>