<?php

class ConfBdd{
    
    public static $conf = array('dev' => array('user' => 'root',
                                        'pwd'  => '',
                                        'name' => 'mysql:host=localhost;dbname=test'));    
    
    public static function getConf($env = 'dev'){
      return self::$conf[$env];
    }
}
    
    
?>    