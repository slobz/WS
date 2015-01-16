<?php

require_once 'Acces.php';
require_once 'Tools/Tools.php';
require_once 'Services/ServiceFactory.php';

use Services\ServiceFactory;

/**
 * Classe faisant appel aux différents WebService en instanciant dynamiquement
 * des services.
 */
class Ws {

    // Services autorisés
    protected $services = array('commentaire', 'restaurant','utilisateur','favoris','image');

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

    // Lancement du service et execution de sa méthode
    public function executeRequest($service,$params) {
        
        $methode = $this->getMethode($params);
        
        header('Content-Type: application/json');
        
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

    // Requete GET
    public function getRequest($service, $params) {

        $objetService = ServiceFactory::getService($service);
        echo $objetService->get($params);

    }

    // Requete POST
    public function postRequest($service, $methode, $params) {
        
        $objetService = ServiceFactory::getService($service);
        
        if($objetService->isMethodeAutorisee($methode)){
            echo $objetService->$methode($params); //
        }else{
             $json = array(
                'error' => true,
                'libelleError' => 'Methode inconnue'
            );
            echo json_encode($json);
        }
    }
}
