<?php

namespace Services;

require_once 'RestaurantService.php';
require_once 'CommentaireService.php';
require_once 'UtilisateurService.php';
require_once 'FavorisService.php';
require_once 'ImagesService.php';

require_once 'BDD/EntityManagerAccessor.php';

use BDD\EntityManagerAccessor;

class ServiceFactory{
    
    public static function getService($service){
        $entityManager = EntityManagerAccessor::getEntityManager();
        
        switch ($service){
            case 'commentaire': return new CommentaireService($entityManager);
            case 'restaurant': return new RestaurantService($entityManager);
            case 'utilisateur': return new UtilisateurService($entityManager);
            case 'favoris' : return new FavorisService($entityManager);
            case 'image' : return new ImagesService($entityManager);
        }
    }
}