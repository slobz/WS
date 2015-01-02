<?php

namespace Services;

require_once 'Service.php';

use Tools;
use Entity\IF26\Commentaire;

class CommentaireService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    //@todo Resto/User vide?
    //@todo Un seul commentaire personne/restaurant
    //@override
    public function add($params) {

        $texte = Tools::getValueFromArray($params, 'texte');
        $note = Tools::getValueFromArray($params, 'note');
        $idRestaurant = Tools::getValueFromArray($params, 'idResto');
        $idUtilisateur = Tools::getValueFromArray($params, 'idUser');

        if (!empty($texte) && !empty($note) && !empty($idRestaurant) && !empty($idUtilisateur)) {

            $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
            $restaurant = $repo->find($idRestaurant);

            $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
            $utilisateur = $repo->find($idUtilisateur);

            // On regarde si l'utilisateur n'a pas déja posté un commentaire concernant le restaurant
            if ($utilisateur->hasCommented($idRestaurant)) {
                $json = array(
                    'error' => true,
                    'libelleError' => 'Restaurant déja commenté'
                );
            } else {

                $commentaire = new Commentaire();
                $commentaire->setNote($note);
                $commentaire->setTexte($texte);
                $commentaire->setRestaurant($restaurant);
                $commentaire->setUtilisateur($utilisateur);

                $this->entityManager->persist($commentaire);
                $this->entityManager->flush();

                // Mise à jour de la note moyenne du restaurant
                $restaurant->updateNoteMoyenne();
                $this->entityManager->persist($restaurant);
                $this->entityManager->flush();

                $json = array(
                    'error' => false
                );
            }
        } else {
            $json = array(
                'error' => true,
                'libelleError' => 'Paramètres manquant'
            );
        }

        return json_encode($json);
    }

    public function get($id = null) {
        
    }

}
