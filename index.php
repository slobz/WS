<?php

require_once 'Ws.php';

$params = array();
$ws = new WS();
$service = $_GET['service'];

if (Tools::isProd()) {
    $request_body = file_get_contents('php://input');
    $params = json_decode($request_body);
}else{
    if (isset($_GET['id'])){
        $params['id'] = $_GET['id']; //@todo
    }
}

$ws->executeRequest($service,$params);