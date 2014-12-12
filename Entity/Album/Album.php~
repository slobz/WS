<?php

namespace Entity\Album;

/** @Entity 
 *  @Table(name="album")
 * 
 *  */
class Album {

    /** @Id 
     *  @Column(type="integer") 
     *  @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="integer") */
    private $total;
    
    /** @Column(length=140) */
    private $titre;
    
    /** @Column(type="integer") */
    private $possede;
    
    /** @Column(length=140) */
    private $img_path;
    
    /** @Column(type="date") */
    private $prochaine_sortie = '0000-00-00';
    
    /** @Column(type="boolean") */
    private $fini = false;
    
    

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
     * Set total
     *
     * @param integer $total
     * @return Album
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Album
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set possede
     *
     * @param integer $possede
     * @return Album
     */
    public function setPossede($possede)
    {
        $this->possede = $possede;

        return $this;
    }

    /**
     * Get possede
     *
     * @return integer 
     */
    public function getPossede()
    {
        return $this->possede;
    }

    /**
     * Set img_path
     *
     * @param string $imgPath
     * @return Album
     */
    public function setImgPath($imgPath)
    {
        $this->img_path = $imgPath;

        return $this;
    }

    /**
     * Get img_path
     *
     * @return string 
     */
    public function getImgPath()
    {
        return $this->img_path;
    }

    /**
     * Set prochaine_sortie
     *
     * @param integer $prochaineSortie
     * @return Album
     */
    public function setProchaineSortie($prochaineSortie)
    {
        $this->prochaine_sortie = $prochaineSortie;

        return $this;
    }

    /**
     * Get prochaine_sortie
     *
     * @return integer 
     */
    public function getProchaineSortie()
    {
        return $this->prochaine_sortie;
    }

    /**
     * Set fini
     *
     * @param boolean $fini
     * @return Album
     */
    public function setFini($fini)
    {
        $this->fini = $fini;

        return $this;
    }

    /**
     * Get fini
     *
     * @return boolean 
     */
    public function getFini()
    {
        return $this->fini;
    }
 
    public function addTomePossede(){
        $this->possede++;
    }
    
    public function removeTomePossede(){
        $this->possede--;
    }
    
    public function addTomeTotal(){
        $this->total++;
    }
    
    public function removeTomeTotal(){
        if($this->total == $this->possede){
            $this->removeTomePossede();   
        }
        
        $this->total--;
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
