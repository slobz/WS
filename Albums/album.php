<?php

// @todo: Finir update + methode magique

require '../Acces.php';
require '../PDO/Bdd.php';
require '../Tools/Tools.php';

const TABLE = 'liste_bd';

// Requete
Acces::accesControl();

$methodes_autorisees = array('add');

// POST
if (Tools::isPostRequest()) {

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);

    if (in_array($data->action, $methodes_autorisees)) {
        $nom_tome = $data->titre;
        addTome($nom_tome);
        header('Content-Type: application/json');
        echo 'ok';
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 501 Not Implemented', true, 501);
    }

    exit;
} else { // GET
    $dbh = Bdd::getInstance();
    $query = " SELECT * FROM " . TABLE;

    $json_data = $dbh::queryToJson($dbh->query($query, true));

    header('Content-Type: application/json');
    echo $json_data;
    exit;
}

/**
 * Met a jour le nombre de tome de +1
 * @param type $tome_name
 */
function addTome($nom_tome) {

    $dbh = Bdd::getInstance();

    // On regarde que la BD existe bien
    $query = "SELECT possede,total  FROM " . TABLE . " WHERE titre = :titre";
    $params = array('titre' => "$nom_tome");
    $result = $dbh->queryWithParam($query, $params, true);
    $res = BDD::resultOneRow($result);

    // Existe et le nombre de tome ne dépasse pas le total
    if ($res->possede < $res->total) {

        $query = "UPDATE " . TABLE . " SET possede = possede + 1 WHERE titre = :titre";
        $dbh->queryWithParam($query, $params);
    }
}
