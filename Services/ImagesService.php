<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Utilisateur.php';
require_once 'Entity/IF26/Image.php';

use Tools;
use Entity\IF26\Utilisateur;
use Entity\IF26\Image;

class ImagesService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    public function add($params) {


        $image = Tools::getValueFromArray($params, 'image');
        $nom = Tools::getValueFromArray($params, 'nom');
        $idRestaurant = Tools::getValueFromArray($params, 'idRestaurant');


        if (empty($image) || empty($nom) || empty($idRestaurant)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Paramètres manquant'
            );
            echo json_encode($json);
        } else {

            $decode = base64_decode($image);
            $uploadOk = file_put_contents("img/" . $nom, $decode);

            // Si l'image est bien sauvegardée
            if ($uploadOk) {

                // Ajout de l'image dans la BDD
                $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
                $restaurant = $repo->findOneBy(array('id' => $idRestaurant));

                //@todo: restaurant null?

                $image = new Image();
                $image->setPath("img/" . $nom);
                $image->setName($nom);
                $image->setRestaurant($restaurant);

                $this->entityManager->persist($image);
                $this->entityManager->flush();

                $json = array('error' => false);
                echo json_encode($json);
            } else {
                $json = array(
                    'error' => true,
                    'libelleError' => 'Erreur lors de l\'upload'
                );
                echo json_encode($json);
            }
        }
    }

    // params = id restaurant
    function get($params) {

        // On retourne le chemin, l'appli chargera l'image via l'URL
        //
            
        $idRestaurant = Tools::getValueFromArray($params, 'idRestaurant');
        
        if (empty($idRestaurant)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Id du restaurant non fournis.'
            );
            echo json_encode($json);
            die;
        }
        
        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $restaurant = $repo->findOneBy(array('id' => $idRestaurant));

        
        if (empty($restaurant)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Restaurant inconnu'
            );
            echo json_encode($json);
        }else{

            $images = $restaurant->getImages();
            
            foreach ($images as $image) {
                $tableauImages[] = $image->toArray();
            }
            
            $json = array("images" => $tableauImages);
                   
            echo json_encode($json);
        }
    }
}