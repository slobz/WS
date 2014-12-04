<?php

namespace Entity\IF26;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

require_once 'Commentaire.php';

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

    /** @Column(type="integer",nullable=true)  */
    private $images;

    /** @Column(length=140) */
    private $description;

    
    public function __construct() {
        $this->commentaires = new ArrayCollection();
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
