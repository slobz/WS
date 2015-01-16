<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Restaurant.php';
require_once 'Entity/IF26/Commentaire.php';

use Entity\IF26\Restaurant;
use Entity\IF26\Commentaire;
use Tools;

class RestaurantService extends Service {

    static $cpt; // Compteur utilisé pour la génération du nom aléatoire de l'image

    public function __construct($em) {
        parent::__construct($em);
        $this->methodeAutorisees[] = 'update';
    }

    /**
     * Ajout d'un restaurant
     * @param array $params
     * @return JSON
     */
    public function add($params) {

        $nom = Tools::getValueFromArray($params, 'nom');
        $description = Tools::getValueFromArray($params, 'description');
        $coordonneeX = Tools::getValueFromArray($params, 'x');
        $coordonneeY = Tools::getValueFromArray($params, 'y');
        $cp = Tools::getValueFromArray($params, 'cp');
        $ville = Tools::getValueFromArray($params, 'ville');
        $rue = Tools::getValueFromArray($params, 'rue');

        $images = array();
        $images[] = Tools::getValueFromArray($params, 'img1');
        $images[] = Tools::getValueFromArray($params, 'img2');
        $images[] = Tools::getValueFromArray($params, 'img3');

        if (!empty($nom) && !empty($description) && !empty($coordonneeX) && !empty($coordonneeY) && !empty($rue) && !empty($ville) && !empty($cp)) {

            $restaurant = new Restaurant();
            $restaurant->setNom($nom);
            $restaurant->setDescription($description);
            $restaurant->setX($coordonneeX);
            $restaurant->setY($coordonneeY);
            $restaurant->setCp($cp);
            $restaurant->setVille($ville);
            $restaurant->setRue($rue);

            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();

            // AJout des images
            for ($i = 0; $i < 3; ++$i) {
                if ($images[$i] != null) {

                    $decode = base64_decode($images[$i]);
                    $path = "img/" . date(time() . self::$cpt++) . ".jpg"; // Attribution d'un nom aléatoire pour l'image
                    $uploadOk = file_put_contents($path, $decode);
                    chmod($path, 0755);

                    if (!$uploadOk) {
                        echo json_encode(array(
                            'error' => true,
                            'libelleError' => 'Erreur lors de l\'upload'));
                    }

                    $image = new \Entity\IF26\Image();
                    $image->setName($i);
                    $image->setRestaurant($restaurant);
                    $image->setPath($path);
                    $this->entityManager->persist($image);
                    $this->entityManager->flush();
                }
            }

            $json = array(
                'error' => false
            );
        } else {
            header("HTTP/1.1 400 BAD REQUEST");
        }

        return json_encode($json);
    }

    /**
     * Mise à jour d'un restaurant
     * @param array $params
     * @return JSON
     */
    public function update($params) {

        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $id = Tools::getValueFromArray($params, 'idRestaurant');

        $nom = Tools::getValueFromArray($params, 'nom');
        $description = Tools::getValueFromArray($params, 'description');
        $cp = Tools::getValueFromArray($params, 'cp');
        $ville = Tools::getValueFromArray($params, 'ville');
        $rue = Tools::getValueFromArray($params, 'rue');
        
        
        if (!empty($id)) { 
            
            $restaurant = $repo->find($id);

            if (empty($restaurant)) { // Si aucun restaurant ne correspont à l'id passé en paramètre
                $json = array(
                    'error' => true,
                    'libelleError' => 'Restaurant inconnu'
                );
                return json_encode($json);
            } else {

                // Mis à jour des champs
                $restaurant->setNom($nom);
                $restaurant->setDescription($description);
                $restaurant->setCp($cp);
                $restaurant->setVille($ville);
                $restaurant->setRue($rue);
                 $this->entityManager->flush();
                
                $json = array(
                    'error' => false,
                    'libelleError' => 'Restaurant mis à jour'
                );
                return json_encode($json);
                
            }
        } else { // Si l'id du restaurant n'a pas été précisé

            $json = array(
                'error' => true,
                'libelleError' => 'L\'id du restaurant doit être precisé'
            );
            return json_encode($json);
        }
    }

    /**
     * Récupération d'un ou tous les restaurants
     * @param array $params
     * @return JSON
     */
    public function get($params) {

        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $id = Tools::getValueFromArray($params, 'id');

        if (!empty($id)) { // SI  l'id est précisé on recupère le restaurant associé

            $restaurant = $repo->find($id);

            $images = $restaurant->getImages();
            foreach ($images as $image) {
                $tableauImages[] = $image->toArray();
            }

            $json = array(
                "restaurant" => $restaurant->toArray(),
                "images" => $tableauImages
            );
        } else { // SINON on récupère l'ensemble des restaurants contenus dans la base

            $restaurants = $repo->findAll();
            foreach ($restaurants as $restaurant) {
                $tableauRestaurants[] = $restaurant->toArray2();
            }


            $json = array('restaurants' => $tableauRestaurants);
        }
        return json_encode($json);
    }

}
