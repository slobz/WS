<?php

require_once 'Acces.php';
require_once 'Tools/Tools.php';
require_once 'Services/ServiceFactory.php';

use Services\ServiceFactory;

class Ws {

    protected $apiKey = 'toto';
    protected $services = array('commentaire', 'restaurant','utilisateur');

    public function __construct() {
        Acces::accesControl();
    }

    public function serviceExiste($service) {
        return in_array($service,$this->services);
    }

    public static function getService($params) {
        if(isset($params['service']))
            return $params['service'];
    }
    
    public static function getMethode($params){
        if(isset($params['methode']))
            return $params['methode'];
    }
    
    

    public function postParameters() {
        
    }

    public function executeRequest($service,$params) {
        
        $methode = $this->getMethode($params);
        
        header('Content-Type: application/json');
        
        echo "@@@ $service @@@";
        
        // Controle du service
        if(!$this->serviceExiste($service)){
            $json = array(
                'error' => true,
                'libelleError' => 'Service inconnu'
            );
            echo json_encode($json);exit;
        }
        
        if (Tools::isPostRequest()) {
            $this->postRequest($service, $methode, $params);
        } else {
            $this->getRequest($service,$params);
        }
    }

    public function getRequest($service, $params) {

        $objetService = ServiceFactory::getService($service);
        echo $objetService->get($params);

    }

    public function postRequest($service, $methode, $params) {
        
        $objetService = ServiceFactory::getService($service);
        
        if($objetService->isMethodeAutorisee($methode)){
            echo $objetService->$methode($params);
        }else{
             $json = array(
                'error' => true,
                'libelleError' => 'Methode inconnue'
            );
            echo json_encode($json);
        }
    }
}
