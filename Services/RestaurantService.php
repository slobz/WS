<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Restaurant.php';
require_once 'Entity/IF26/Commentaire.php';

use Entity\IF26\Restaurant;
use Entity\IF26\Commentaire;
use Tools;

class RestaurantService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    //@override
    public function add($params) {

        $nom = Tools::getValueFromArray($params,'nom');
        $description = Tools::getValueFromArray($params,'description');
        $coordonneeX = Tools::getValueFromArray($params, 'x');
        $coordonneeY = Tools::getValueFromArray($params, 'y');
        
        
        if (!empty($nom) && !empty($description) && !empty($coordonneeX) && !empty($coordonneeY)) {
            
            $restaurant = new Restaurant();
            $restaurant->setNom($nom);
            $restaurant->setDescription($description);
            $restaurant->setX($coordonneeX);
            $restaurant->setY($coordonneeY);
            
            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();
            
              $json = array(
                'error' => false
            );
            
        } else {
            header("HTTP/1.1 400 BAD REQUEST");
        }
        
        return  $json;
        
    }

    //@override
    public function get($params) {

        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $id = Tools::getValueFromArray($params,'id');
        
        if (!empty($id)) {

            $restaurant = $repo->find($id);
            $commentaires = $restaurant->getCommentaires();

            foreach ($commentaires as $commentaire) {
                $tableauCommentaires[] = $commentaire->toArray();
            }

            $json = array(
                "restaurant" => $restaurant->toArray(),
                "commentaires" => $tableauCommentaires
            );
        } else {
            
            $restaurants = $repo->findAll();
            foreach ($restaurants as $restaurant) {
                $tableauRestaurants[] = $restaurant->toArray();
            }
            
            
            $json = array('restaurants' => $tableauRestaurants);
            
        }
        return json_encode($json);
    }

}
