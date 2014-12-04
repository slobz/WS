<?php

/**
 * Crée le 27/10/14
 * Classe chargé des controles d'url
 * 
 * Version 1.0 
 * 
 */

class Acces {

    static $url_autorisees = array('Access-Control-Allow-Origin: *',
                                   'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept    ');

    /**
     * Charge les URL autorisé a appeler notre WS
     */
    static function accesControl() {
        foreach (self::$url_autorisees as $url) {
            header($url);
        }
    }
    
    /**
     * Retourne vrai si la clé d'api est correcte
     * @param type $apiKey
     * @param type $keyGiven
     * @return boolean
     */
    static function isApiKeyValid($apiKey, $keyGiven){
        return ($apiKey == $keyGiven);
    }

}
