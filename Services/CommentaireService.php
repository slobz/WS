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
                isset($commentaireToAdd->id)) {

            $repo = $this->entityManager->getRepository(Service::ENTITE_RESTAURANT);
            $restaurant = $repo->find($commentaireToAdd->id);

            $commentaire = new Commentaire();
            $commentaire->setNote($commentaireToAdd->note);
            $commentaire->setTexte($commentaireToAdd->texte);
            $commentaire->setRestaurant($restaurant);

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
        } else {
            header("HTTP/1.1 400 BAD REQUEST");
        }
    }

    public function get($id = null){}
}
