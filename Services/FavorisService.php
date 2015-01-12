<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Utilisateur.php';

use Tools;
use Entity\IF26\Utilisateur;

class FavorisService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    public function add($params) {

        $idUtilisateur = Tools::getValueFromArray($params,'idUtilisateur');
        $idRestaurant = Tools::getValueFromArray($params,'idRestaurant');

        $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
        $user = $repo->findOneBy(array('id' => $idUtilisateur));
        
        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $restaurant = $repo->findOneBy(array('id' => $idRestaurant));
        
        $user->addRestaurantFavoris($restaurant);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        $json = array('error' => false);
        return json_encode($json);
        
    }
    
    public function get($params) {

        $idUtilisateur = Tools::getValueFromArray($params, 'idUtilisateur');

        // Pas de login specifiée
        if (empty($idUtilisateur)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Id non precisé'
            );
            return json_encode($json);
        }

        // On recupère l'id de l'utilisateur qui correspont au login
        // On regarde si le login existe
        $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
        $user = $repo->findOneBy(array('id'=>$idUtilisateur));

        // Utilisateur
        if (empty($user)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Utilisateur inconnu'
            );

            return json_encode($json);
        }

        // On recupère ses restaurants favoris
        $restaurants = $user->getRestaurantsFavoris();
        $tableauRestaurants = array();
        foreach ($restaurants as $restaurant) {
            $tableauRestaurants[] = $restaurant->toArray2();
        }

        $json = array('error' => false,'restaurants' => $tableauRestaurants);
        return json_encode($json);

    }

}
