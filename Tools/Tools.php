<?php
/**
* Utilitaire
* @todo version PROD/DEV
* @author seb
*/


class Tools {

    static function isPostRequest(){
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    
}


?>