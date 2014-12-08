<?php

namespace Entity\IF26;

use Doctrine\ORM\Mapping as ORM;

/** @Entity 
 *  @Table(name="utilisateur")
 * 
 * */
class Utilisateur {

    /** @Id 
     *  @Column(type="integer") 
     *  @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(length=140) */
    private $login;

    /** @Column(length=140) */
    private $pwd;
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }

}
