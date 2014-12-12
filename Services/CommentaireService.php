<?php

namespace Services;

require_once 'Service.php';

class CommentaireService extends Service {
    
    
    public function __construct($em) {
        parent::__construct($em);
        
    }

    //@todo return
    //@override
    public function add() {

        $commentaireToAdd = $this->data->commentaire;

        if (isset($commentaireToAdd->texte) && isset($commentaireToAdd->note) &&
                isset($commentaireToAdd->idRestaurant) && isset($commentaireToAdd->idUtilisateur)) {

            $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
            $restaurant = $repo->find($commentaireToAdd->idRestaurant);
            
            $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
            $utilisateur = $repo->find($commentaireToAdd->idUtilisateur);

            $commentaire = new Commentaire();
            $commentaire->setNote($commentaireToAdd->note);
            $commentaire->setTexte($commentaireToAdd->texte);
            $commentaire->setRestaurant($restaurant);
            $commentaire->setUtilisateur($utilisateur);

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            
            $json = array(
                'error' => false
            );
            
            
        } else {
           $json = array(
                'error' => true,
                'libelleError' => 'Paramètres manquant'
            );
        }
         
        return json_encode($json);
        
    }

    public function get($id = null){}
}
