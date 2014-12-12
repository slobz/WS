<?php

namespace Entity\IF26;

use Doctrine\ORM\Mapping as ORM;

/** @Entity 
 *  @Table(name="commentaire")
 * 
 * */
class Commentaire {

    /** @Id 
     *  @Column(type="integer") 
     *  @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(length=140) */
    private $texte;
    
    /** @Column(type="integer") */
    private $note;
    
    /**
    * @ManyToOne(targetEntity="Restaurant", inversedBy="commentaires")
    * @JoinColumn(name="restaurant_id", referencedColumnName="id")
    **/
    private $restaurant;
    
    /**
    * @ManyToOne(targetEntity="Utilisateur", inversedBy="commentaires")
    * @JoinColumn(name="utilisateur_id", referencedColumnName="id")
    **/
    private $utilisateur;
    
    
    public function getRestaurant() {
        return $this->restaurant;
    }

    public function setRestaurant($restaurant) {
        $this->restaurant = $restaurant;
    }

    public function getUtilisateur(){
        return $this->utilisateur;
    }
    
    public function setUtilisateur($utilisateur){
        $this->utilisateur = $utilisateur;
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getTexte() {
        return $this->texte;
    }

    public function getNote() {
        return $this->note;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTexte($texte) {
        $this->texte = $texte;
    }

    public function setNote($note) {
        $this->note = $note;
    }
    
    
    /**
     * Convertir notre objet en tableau associatif
     * @return array
     */
    public function toArray(){
        
        foreach ($this as $k=>$v){
            $array[$k] = $v;
        }
        
        return $array;
    }

}
