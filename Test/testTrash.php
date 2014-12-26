<?php


require '../Acces.php';
require '../PDO/Bdd.php';
require '../Tools/Tools.php';
require '../Entity/IF26/Restaurant.php';
//require '../Albums/commentaireFnc.php';
require '../Albums/restaurantFnc.php';


require_once '../BDD/bootstrap.php'; // ...

use Entity\IF26\Commentaire;
use Entity\IF26\Restaurant;

//const TABLE_RESTAURANT = 'Entity\IF26\Restaurant';
//const TABLE_COMMENTAIRE = 'Entity\IF26\Commentaire';


// Test commentaire
/*
$commentaire = array(
    'commentaire' => array(
                        'texte' => ' s',
                        'note' => 5,
                        'id' => 1)
);

$object = json_decode(json_encode($commentaire), FALSE);
ajouterCommentaire($entityManager, $object);
*/


// Test restaurant
/*
$restaurant = array(
    'restaurant' => array('nom' => 'Chez Léon',
                          'description' => 'YOLO')
);

$object = json_decode(json_encode($restaurant), FALSE);
ajouterRestaurant($entityManager, $object);
*/

// Test WS V2.0
