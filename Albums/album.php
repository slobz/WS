<?php

require '../Acces.php';
require '../PDO/Bdd.php';
require '../Tools/Tools.php';
require '../Entity/Album/Album.php';
require_once '../Test/bootstrap.php'; // ...

use Entity\Album\Album;

const TABLE = 'album';
        const TABLEU = 'Entity\Album\Album';

// Requete
Acces::accesControl();

/**
 * Contient les méthodes appelé par le WS
 */
$methodes_autorisees = array('addPossede' => 'ajoutAlbumPossede',
    'removePossede' => 'retraitAlbumPossede',
    'add' => 'ajoutTotalAlbum',
    'remove' => 'retraitTotalAlbum',
    'addAlbum' => 'ajouterNouvelAlbum');

// Connecteur avec la table
//$albumRepo = $entityManager->getRepository(TABLEU);
// POST
if (Tools::isPostRequest()) {

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body);

    if (array_key_exists($data->action, $methodes_autorisees)) {
        $methode = $data->action;

        // Appel de la fonction qui va bien en fonction de $methode
        $result = $methodes_autorisees[$methode]($entityManager, $data);
        header('Content-Type: application/json');
        echo $result;
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 501 Not Implemented', true, 501);
    }

    exit;
} else { // GET
    $albums = getAllAlbums($entityManager);
    header('Content-Type: application/json');
    echo $albums;
    exit;
}

/**
 * Met à jour le nombre de tome possede +1
 * @param doctrine $em
 * @param array $data
 */
function addTomePossede($em, $data) {

    $repo = $em->getRepository(TABLEU);
    $nomTome = $data->titre;
    $tome = $repo->findOneBy(array('titre' => $nomTome));

    if (empty($tome)) {
        header("HTTP/1.0 404 Not Found");
    } else {
        if ($tome->getPossede() < $tome->getTotal()) {
            $tome->addTomePossede();
            $em->persist($tome);
            $em->flush();
        }
    }
}

/**
 * Met à jour le nombre de tome possede -1
 * @param doctrine $em
 * @param array $data
 */
function retraitAlbumPossede($em, $data) {
    $repo = $em->getRepository(TABLEU);
    $nomTome = $data->titre;
    $tome = $repo->findOneBy(array('titre' => $nomTome));

    if (empty($tome)) {
        header("HTTP/1.0 404 Not Found");
    } else {
        if ($tome->getPossede() > 0) {
            $tome->removeTomePossede();
            $em->persist($tome);
            $em->flush();
        }
    }
}

/**
 * Ajoute un nouvel album
 * @param doctrine $em
 * @param array $data
 */
function ajouterNouvelAlbum($em, $data) {

    $albumToAdd = $data->album;

    if (isset($albumToAdd->titre) && isset($albumToAdd->tomePossede) &&
            isset($albumToAdd->tomeTotal) && isset($albumToAdd->image)) {

        $album = new Album();
        $album->setTitre($albumToAdd->titre);
        $album->setPossede($albumToAdd->tomePossede);
        $album->setTotal($albumToAdd->tomeTotal);
        $album->setImgPath($albumToAdd->image);

        if (isset($albumToAdd->terminee))
            $album->setFini($albumToAdd->terminee);

        $em->persist($album);
        $em->flush();
    }else{
        header("HTTP/1.1 400 BAD REQUEST");
    }
}

/**
 * Incremente le nombre de tome total de +1
 * @param type $em
 * @param array $data
 */
function ajoutTotalAlbum($em, $data) {

    $repo = $em->getRepository(TABLEU);
    $nomTome = $data->titre;
    $tome = $repo->findOneBy(array('titre' => $nomTome));

    if (empty($tome)) {
        header("HTTP/1.0 404 Not Found");
    } else {
        $tome->addTomeTotal();
        $em->persist($tome);
        $em->flush();
    }
}

/**
 * Decremente le nombre de tome total de -1
 * @param type $em
 * @param array $data
 */
function retraitTotalAlbum($em, $data) {

    $repo = $em->getRepository(TABLEU);
    $nomTome = $data->titre;
    $tome = $repo->findOneBy(array('titre' => $nomTome));

    if (empty($tome)) {
        header("HTTP/1.0 404 Not Found");
    } else {
        if ($tome->getTotal() > 1) {
            $tome->removeTomeTotal();
            $em->persist($tome);
            $em->flush();
        }
    }
}

/**
 * Retourne un JSON cotenant la liste de tous les albums
 * @param type $entityManager
 * @return array
 */
function getAllAlbums($em) {

    $repo = $em->getRepository(TABLEU);
    $albums = $repo->findAll();

    foreach ($albums as $album) {
        $jsonData[] = $album->toArray();
    }

    return json_encode($jsonData);
}
