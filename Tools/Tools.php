<?php

/**
 * Utilitaire
 * @author seb
 */
class Tools {

    static $url_dev = 'localhost';
    static $url_prod = 'brikabrokz.fr';

    static function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    static function isProd() {
        return $_SERVER['HTTP_HOST'] == self::$url_prod;
    }

    static function isDev() {
        return $_SERVER['HTTP_HOST'] == self::$url_dev;
    }
    
    
    /**
     * Permet d'extraite une valeur d'un tableau, si la valeur n'existe pas on
     * retourne null
     * @param type $value
     * @return $value
     */
    static function getValueFromArray($params,$key){
        return isset($params[$key])?$params[$key]:null;
    }


}
?>