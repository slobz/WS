<?php

require_once 'Ws.php';

$params = array();
$ws = new WS();

if (Tools::isPostRequest()) {
    
    $params = $_POST;
    $service = isset($params['service'])?$params['service']:null;
    
}else{
    $request_body = file_get_contents('php://input');
    $service = isset($_GET['service'])?$_GET['service']:null;
    
    foreach ($_GET as $k=>$v){
        if($k == "service")
            continue;
        $params[$k] = $v;
    }
}

$ws->executeRequest($service,$params);