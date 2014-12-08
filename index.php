<?php

require_once 'Ws.php';

$params = array();
$ws = new WS();
$service = $_GET['service'];

if (Tools::isPostRequest()) {
    $request_body = file_get_contents('php://input');
    $params = json_decode($request_body);
}else{
    //if (isset($_GET['id'])){
     //   $params['id'] = $_GET['id']; //@todo
    //}
    $request_body = file_get_contents('php://input');
    
    foreach ($_GET as $k=>$v){
        if($k == "service")
            continue;
        $params[$k] = $v;
    }
}

$ws->executeRequest($service,$params);