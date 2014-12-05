<?php

namespace Services;

require_once 'Service.php';
require_once '../Entity/IF26/Restaurant.php';
require_once '../Entity/IF26/Commentaire.php';

use Entity\IF26\Restaurant;
use Entity\IF26\Commentaire;

class RestaurantService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    //@override
    public function add() {

        $restaurantToAdd = $this->data->restaurant;

        if (isset($restaurantToAdd->nom) && isset($restaurantToAdd->description)) {
            
            $restaurant = new Restaurant();
            $restaurant->setNom($restaurantToAdd->nom);
            $restaurant->setDescription($restaurantToAdd->description);

            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();
        } else {
            
            header("HTTP/1.1 400 BAD REQUEST");
        }
    }

    //@override
    public function get($id = null) {

        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);

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
