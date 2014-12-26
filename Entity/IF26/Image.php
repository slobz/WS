<?php

namespace Entity\IF26;

use Doctrine\ORM\Mapping as ORM;

/** @Entity 
 *  @Table(name="image")
 * 
 * */
class Image {

    /** @Id 
     *  @Column(type="integer") 
     *  @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(length=140) */
    private $name;
    
    /** @Column(length=255) */
    private $path;
    
   /**
    * @ManyToOne(targetEntity="Restaurant", inversedBy="images")
    * @JoinColumn(name="restaurant_id", referencedColumnName="id")
    **/
    private $restaurant;
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->path;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPath($path) {
        $this->path = $path;
    }
        
    public function getRestaurant(){
        return $this->restaurant;
    }
    
    public function setRestaurant($restaurant){
        $this->restaurant = $restaurant;
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
