<?

require_once Wp_Custom_Drive . '/vendor/autoload.php';

self::$url = 'https://sour-smoke.localsite.io';
            $this->dotenv = Dotenv\Dotenv::createImmutable(Wp_Custom_Drive);
            $this->dotenv->load();

            public static function getLive($login){
        $url = add_query_arg(array(
                'key' => $_ENV['key'],
                'url' => wp_parse_url(self::$url, PHP_URL_PATH),
                'dimension' => $_ENV['dimension'],
            ),
            'https://api.screenshotmachine.com');

        return $url;
        
      }