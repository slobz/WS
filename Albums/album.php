<?php

// @todo: maniere plus propre de gerer le cas ou l'album n'existe pas''

require '../Acces.php';
require '../PDO/Bdd.php';
require '../Tools/Tools.php';

        const TABLE = 'liste_bd';

// Requete
Acces::accesControl();

$methodes_autorisees = array('addPossede', 'removePossede','add','remove');

// POST
if (Tools::isPostRequest()) {

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);

    if (in_array($data->action, $methodes_autorisees)) {

        $methode = $data->action;
        $nom_tome = $data->titre;

        // Appel de la fonction qui va bien
        $function = $methode."Tome";
        $function($nom_tome);
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
 * Met a jour le nombre de tome possede de +1
 * @param type $tome_name
 */
function addPossedeTome($nom_tome) {

    $dbh = Bdd::getInstance();
    $params = array('titre' => "$nom_tome");
    $res = getTome($nom_tome);

    // le nombre de tome ne dépasse pas le total
    if ($res && $res->possede < $res->total) {
        $query = "UPDATE " . TABLE . " SET possede = possede + 1 WHERE titre = :titre";
        $dbh->queryWithParam($query, $params);
    }
}

/**
 * Met à jour le nombre de tome total de +1
 * @param string $nom_tome
 */
function addTome($nom_tome) {

    $dbh = Bdd::getInstance();
    $params = array('titre' => "$nom_tome");
    $res = getTome($nom_tome);

    if ($res) {
        $query = "UPDATE " . TABLE . " SET total = total + 1 WHERE titre = :titre";
        $dbh->queryWithParam($query, $params);
    }
}

/**
 * Met à jour le nombre de tome total de -1
 * @param string $nom_tome
 */
function removeTome($nom_tome){
    
    $dbh = Bdd::getInstance();
    $params = array('titre' => "$nom_tome");
    $res = getTome($nom_tome);

    // le nombre de tome ne dépasse pas le total
    if ($res && $res->total > 1) {
        
        // Si on a tous les tomes et qu'on diminu le total, on diminu aussi le nombre possede
        if ($res->possede == $res->total){
            removePossedeTome($nom_tome);
        }
        
        $query = "UPDATE " . TABLE . " SET total = total - 1 WHERE titre = :titre";
        $dbh->queryWithParam($query, $params);
        
    }
}

/**
 * Met à jour le nombre de tome possedede -1
 * @param type $nom_tome
 */
function removePossedeTome($nom_tome) {

    $dbh = Bdd::getInstance();
    $params = array('titre' => "$nom_tome");
    $res = getTome($nom_tome);

    // Existe et le nombre de tome ne passe pas en dessous de 0
    if ($res && $res->possede > 0) {
        $query = "UPDATE " . TABLE . " SET possede = possede -1 WHERE titre = :titre";
        $dbh->queryWithParam($query, $params);
    }
}

/**
 * Retourne vrai si l'album passé en paramètre existe dans la BD
 * @param type $nom_tome
 */
function albumExiste($nom_tome) {

    $dbh = Bdd::getInstance();

    // On regarde que la BD existe bien
    $query = "SELECT possede,total  FROM " . TABLE . " WHERE titre = :titre ";
    $params = array('titre' => "$nom_tome");
    $result = $dbh->queryWithParam($query, $params, true);

    return (BDD::rowCount($result) == 1);
}

/**
 * Retourne les infos d'un tome
 * @param type $nom_tome
 * @return type
 */
function getTome($nom_tome) {

    if (albumExiste($nom_tome)) {

        $dbh = Bdd::getInstance();

        $query = "SELECT possede,total  FROM " . TABLE . " WHERE titre = :titre";
        $params = array('titre' => "$nom_tome");
        $result = $dbh->queryWithParam($query, $params, true);

        return BDD::resultOneRow($result);
    } else {
        header("HTTP/1.0 404 Not Found");
    }
}
