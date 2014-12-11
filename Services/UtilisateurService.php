<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Utilisateur.php';
require_once './Tools/PasswordHash.php';

use PasswordHash;
use Tools;
use Entity\IF26\Utilisateur;

class UtilisateurService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    //@todo SANITIZE?
    //@todo >= 6 caracs
    //@override
    public function add($params) {
        
        $login = Tools::getValueFromArray($params, 'login');
        $pwd = Tools::getValueFromArray($params, 'pwd');

        // On controle l'unicité du login
        $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
        $user = $repo->findOneBy(array('login' => $login));
        
        if(empty($user)){
            // On Hash le mot de passe, la méthode HashPassword attribue automatiquement
            // une clé de salage génerée alatoirement au mot de passe
            $t_hasher = new PasswordHash(8, FALSE);
            $hash = $t_hasher->HashPassword($pwd);

            $utilisateur = new Utilisateur();
            $utilisateur->setLogin($login);
            $utilisateur->setPwd($hash);

            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            $json = array(
                'error' => false
            );
        }else{
            $json = array(
                'error' => true,
                'libelleError' => 'Ce login est déja utilisé'
            );
        }
        
        return json_encode($json);
    }

    //@override
    public function get($params) {

        $login = Tools::getValueFromArray($params, 'login');
        $pwd = Tools::getValueFromArray($params, 'pwd');

        if (empty($login)) {
            $json = array(
                'error' => true,
                'libelleError' => 'Le login doit etre specifie'
            );
        } else {

            // On regarde si le login existe
            $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
            $user = $repo->findOneBy(array('login' => $login));

            if (empty($user)) { // Login inconnu
                $json = array(
                    'error' => true,
                    'libelleError' => 'Login inconnu'
                );
            } else { // Connexion
                $json = $this->connexion($user, $pwd);
            }
        }

        return json_encode($json);
    }

    private function connexion($user, $pwd) {

        $t_hasher = new PasswordHash(8, FALSE);
         
        // On campare les deux signatures des mots de passe
        if ($t_hasher->CheckPassword($pwd,$user->getPwd())) { 
            $json = array(
                'error' => 'false',
                'token' => 'tokenvalue...'
            );
        } else {
            $json = array(
                'error' => true,
                'libelleError' => 'Mot de passe incorrect'
            );
        }
        return $json;
    }
}
