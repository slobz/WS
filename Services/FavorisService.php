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

        $login = Tools::getValueFromArray($params, 'login');

        // Pas de login specifiée
        if (empty($login)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Le login doit etre specifie'
            );
            return json_encode($json);
        }

        // On recupère l'id de l'utilisateur qui correspont au login
        // On regarde si le login existe
        $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
        $user = $repo->findOneBy(array('login' => $login));

        // Login inconnu
        if (empty($user)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Login inconnu'
            );

            return json_encode($json);
        }

        // On recupère ses restaurants favoris
        $restaurants = $user->getRestaurantsFavoris();
        foreach ($restaurants as $restaurant) {
            $tableauRestaurants[] = $restaurant->toArray();
        }

        $json = array('error' => false,'restaurants' => $tableauRestaurants);
        return json_encode($json);


    }

}
