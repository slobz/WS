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


    /**
     * Récupération des chemins d'images associées à un restaurant
     * @param array $params
     * @return JSON 
     */
    function get($params) {

            
        $idRestaurant = Tools::getValueFromArray($params, 'idRestaurant');
        
        // ID restaurant non fournie
        if (empty($idRestaurant)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Id du restaurant non fournis.'
            );
            return json_encode($json);
        }
        
        $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
        $restaurant = $repo->findOneBy(array('id' => $idRestaurant));


        // Si l'id ne correspont à aucun restaurant
        if (empty($restaurant)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Restaurant inconnu'
            );
            return json_encode($json);
        }else{

            $images = $restaurant->getImages();
            
            foreach ($images as $image) {
                $tableauImages[] = $image->toArray();
            }
            
            $json = array("images" => $tableauImages);
                   
            return json_encode($json);
        }
    }
}