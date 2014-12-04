<?php

require_once '../BDD/bootstrap2.php';
require_once 'RestaurantService.php';
require_once 'CommentaireService.php';


class ServiceFactory{
    
    
    public static function getService($service){
        $entityManager = Bootstrap::getEm();
        
        switch ($service){
            case 'commentaire': return new CommentaireService($entityManager);
            case 'restaurant': return new RestaurantService($entityManager);
        }
    }
    
}