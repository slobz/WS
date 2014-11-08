<?php

/**
 * Utilitaire
 * @todo version PROD/DEV
 * @author seb
 */
class Tools {

    static $url_dev = 'localhost';
    static $url_prod = '';

    static function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    static function isProd() {
        return $_SERVER['HTTP_HOST'] == self::$url_prod;
    }

    static function isDev() {
        return $_SERVER['HTTP_HOST'] == self::$url_dev;
    }


}
?>