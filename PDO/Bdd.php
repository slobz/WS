<?php

/**
 * BD
 * @todo Mode Prod
 * @todo Message erreur
 */

include 'ConfBdd.php';

class Bdd {
    
    private static $instance;

    private $dbh;
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Bdd();
        }
        return self::$instance;
    }

    private function Bdd() {
        
        $conf = ConfBdd::getConf();
        $this->dbh = new PDO($conf['name'],$conf['user'],$conf['pwd']);
        
    }
    
    /**
     * Requete simple
     * On retourne par défaut un tableau associatif
     * @param type $query
     * @return type
     */
    public function query($query,$set_fetch = false){
        $result = $this->dbh->query($query);
        
        if ($set_fetch == true)
            $result->setFetchMode(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    /**
     * Requete avec param (fournis sous la forme k => v)
     * 
     * @param type $query
     * @param type $params
     */
    public function queryWithParam($query,$params,$set_fetch = false){
        $req = $this->dbh->prepare($query);
        $req->execute($params);
        
        if ($set_fetch == true)
            $req->setFetchMode(PDO::FETCH_OBJ);
        
        return $req->fetchAll();
    }
    
    /**
     * Retourne la ligne des requetes qui ne retourne qu'une ligne
     * utilisée pour plus de clarté dans le code
     * @param type $result
     * @return type
     */
    public static function resultOneRow($result){
        return (empty($result)?false:$result[0]);
    }
    
    /**
     * Retourne le nombre de ligne résultante
     * @param type $result
     * @return int
     */
    public static function rowCount($result){
        return count($result);
    }
    
    
    /**
     * Retourne le resultat d'une requete sous un JSON
     * @param type $query
     */
    public static function queryToJson($result){
        
        $data = array();
        
        foreach ($result as $k=>$v){
            $data[$k] = $v;
        }
        
        return json_encode($data);
    }
    
}
