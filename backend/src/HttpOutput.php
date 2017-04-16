<?php
namespace wapmorgan\altarix;

class HttpOutput {
    static public $codes = array(
        400 => 'Bad Request',
        404 => 'Not Found',
    );

    public function error($code, $message) {
        header($_SERVER['SERVER_PROTOCOL'].' '.$code.' '.(isset(self::$codes[$code])) ? self::$codes[$code] : null);
        echo <<<HTML
<html><head><title>$message</title></head>
<body>
<h1>Error $code</h1>
$message
</body>
HTML;
        exit();
    }

    public function outputJson($content) {
        $encoded = json_encode($content);
        header('Content-Type: application/json');
        header('Content-Length: '.strlen($encoded));
        echo $encoded;
        exit();
    }
}
