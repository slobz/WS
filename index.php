<?php

require_once 'Ws.php';

$params = array();
$ws = new WS();

/**
 * Fichier lancant l'appel à la classe WebService
 * Recupère les paramètres/services en fonctions du type de requete et 
 * les transmet à la classe WebService qui sera chargée d'appeler les services/méthodes
 * correspondan
 */


if (Tools::isPostRequest()) { // Requete de type POST
    
    $params = $_POST;
    $service = isset($params['service'])?$params['service']:null; 
    
}else{ // Requete GET
    
    $request_body = file_get_contents('php://input');
    $service = isset($_GET['service'])?$_GET['service']:null;
    
    // Tableaux contenant les paramètres
    foreach ($_GET as $k=>$v){
        if($k == "service")
            continue;
        $params[$k] = $v;
    }
}

$ws->executeRequest($service,$params);