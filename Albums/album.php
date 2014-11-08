<?php

// @todo: maniere plus propre de gerer le cas ou l'album n'existe pas''
// @todo: Classe album pour gérer tout ça?
// @todo: tableau associatif pour pas avoir des noms de fonction degueux

require '../Acces.php';
require '../PDO/Bdd.php';
require '../Tools/Tools.php';

        const TABLE = 'liste_bd';

// Requete
Acces::accesControl();

$methodes_autorisees = array('addPossede', 'removePossede', 'add', 'remove', 'addAlbum');

// POST
if (Tools::isPostRequest()) {

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);

    if (in_array($data->action, $methodes_autorisees)) {

        $methode = $data->action;

        // Appel de la fonction qui va bien
        $function = $methode . "Tome";
        $t = $function($data);
        header('Content-Type: application/json');
        echo $t;
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
function addPossedeTome($data) {

    $nom_tome = $data->titre;
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
function addTome($data) {

    $nom_tome = $data->titre;
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
function removeTome($data) {

    $nom_tome = $data->titre;
    $dbh = Bdd::getInstance();
    $params = array('titre' => "$nom_tome");
    $res = getTome($nom_tome);

    // le nombre de tome ne dépasse pas le total
    if ($res && $res->total > 1) {

        // Si on a tous les tomes et qu'on diminu le total, on diminu aussi le nombre possede
        if ($res->possede == $res->total) {
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
function removePossedeTome($data) {

    $nom_tome = $data->titre;
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

/**
 * Ajout d'un nouvel album dans la BDD
 * @param type $album
 */
function addAlbumTome($data) {

    $album = $data->album;
    $titre = $album->titre;
    $tomeTotaux = $album->tomeTotal;
    $tomePossede = $album->tomePossede;
    $image = $album->image;
    
    $terminee = false;
    if(isset($album->terminee))
        $terminee = true;
        
    //$terminee = $album->terminee;
    //
    // Controle des données
    if ($titre && $tomeTotaux && $tomePossede && $image &&
            is_int($tomeTotaux) && is_int($tomePossede)) {
        
        $dbh = Bdd::getInstance();
        $query = "INSERT INTO ".TABLE." (total,possede,fini,prochaine_sortie,titre,img_path) "
                . "VALUES(:total,:possede,:fini,:prochaine_sortie,:titre,:img_path)";
        
        $params = array('titre' => $titre,
                        'total' => $tomeTotaux,
                        'possede' => $tomePossede,
                        'fini'  => $terminee,
                        'prochaine_sortie' => '0000-00-00',
                        'img_path' => $image);
        
        $dbh->update($query,$params);
        
    } else {
        return false;
    }

}
