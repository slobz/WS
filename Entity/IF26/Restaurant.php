<?php

namespace Entity\IF26;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

require_once 'Commentaire.php';
require_once 'Image.php';

/** @Entity 
 *  @Table(name="restaurant")
 * 
 *  */
class Restaurant
{
    
    
    /** @Id 
     *  @Column(type="integer") 
     *  @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(length=140) */
    private $nom;

    /**
     * @OneToMany(targetEntity="Commentaire", mappedBy="restaurant")
     **/
    private $commentaires;

    /**
     * @OneToMany(targetEntity="Image", mappedBy="restaurant")
     **/
    private $images;

    /** @Column(type="float",nullable=true)  */
    private $note;
    
    /** @Column(length=140) */
    private $description;

    /** @Column(length=140) */
    private $ville;
    
    /** @Column(length=140) */
    private $rue;

    /** @Column(length=140) */
    private $cp;
    
    /** @Column(type="float")  */
    private $x;
    
    /** @Column(type="float")  */
    private $y;
    
    
    public function __construct() {
        $this->commentaires = new ArrayCollection();
        $this->images = new ArrayCollection();
    }
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Restaurant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set commentaires
     *
     * @param integer $commentaires
     * @return Restaurant
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return integer 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set images
     *
     * @param integer $images
     * @return Restaurant
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return integer 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Restaurant
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    public function getX(){
        return $this->x;
    }
    
    public function getY(){
        return $this->y;
    }
    
    public function setX($x){
        $this->x = $x;
    }
    
    public function setY($y){
        $this->y = $y;
    }
    
    public function getNote(){
        return $this->note;
    }
    
    public function setNote($note){
        $this->note = $note;
    }

    public function getCp(){
        return $this->cp;
    }
    
    
    public function getVille(){
        return $this->ville;
    }
    
    
    public function getRue(){
        return $this->rue;
    }
    
    public function setRue($rue){
        $this->rue = $rue;
    }
    
    
    public function setVille($ville){
        $this->ville = $ville;
    }
    
    
    public function setCp($cp){
        $this->cp = $cp;
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
    
    public function updateNoteMoyenne(){
        
        $note = 0;
        $nbCommentaire = count($this->commentaires);
        
        if($nbCommentaire == 0){
            $this->note = 0;
        }else{
            foreach ($this->commentaires as $commentaire){
                $note += $commentaire->getNote();
            }
            $this->note = $note/$nbCommentaire;
        }
    }
    
}
