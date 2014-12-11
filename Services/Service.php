<?php

namespace Services;

abstract class Service {

    const ENTITE_COMMENTAIRE = 'Entity\IF26\Commentaire';
    const ENTITE_RESTAURANT  = 'Entity\IF26\Restaurant';
    const ENTITE_UTILISATEUR  = 'Entity\IF26\Utilisateur';
    
    protected $methodeAutorisees;
    
    protected $entityManager;

    protected $data;
    
    public function __construct($em) {
        $this->entityManager = $em;
        $this->methodeAutorisees[] = 'add';
    }

    public function isMethodeAutorisee($methode){
        return in_array($methode, $this->methodeAutorisees);
    }
    
    public function setData($data){
        $this->data = $data;
    }
    
    public function getData(){
        return $this->data;
    }
    
}
