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

    /**
     * Ajout d'un utilisateur
     * @param array $params
     * @return JSON
     */
    public function add($params) {
        
        $login = Tools::getValueFromArray($params, 'login');
        $pwd = Tools::getValueFromArray($params, 'pwd');

        // On controle la validité du login: 6caractère et composé uniquement de
        // lettre et de chiffre
        $loginOk = preg_match("/^[a-zA-Z0-9]{6,15}$/",$login);
        if(!$loginOk){
             $json = array(
                'error' => true,
                'libelleError' => 'Le login doit uniquement comporter des lettres et des chiffres'
            );
            return json_encode($json);
        }
        
        // On controle la validité du mot de passe entre 6 et 60 caractères
        $pwdOk = preg_match("/^.{6,60}$/", $pwd);
        if(!$pwdOk){
             $json = array(
                'error' => true,
                'libelleError' => 'La longueur du mot de passe doit être comprise entre 6 et 60 caractères.'
            );
            return json_encode($json);
        }
        
        // On controle l'unicité du login
        $repo = $this->entityManager->getRepository(Service::ENTITE_UTILISATEUR);
        $user = $repo->findOneBy(array('login' => $login));
        
        if(empty($user)){
            // On Hash le mot de passe, la méthode HashPassword attribue automatiquement
            // une clé de salage génerée aléatoirement au mot de passe
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

    /**
     * Récupération d'un utilisateur
     * @param array $params
     * @return JSON
     */
    public function get($params) {

        $login = Tools::getValueFromArray($params, 'login');
        $pwd = Tools::getValueFromArray($params, 'pwd');

        // Si le login n'est pas spécifié
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

    /**
     * Vérification des bons paramètres de connexion
     * @param String $user
     * @param String $pwd
     * @return boolean
     */
    private function connexion($user, $pwd) {

        $t_hasher = new PasswordHash(8, FALSE);
         
        // On compare les deux signatures des mots de passe
        if ($t_hasher->CheckPassword($pwd,$user->getPwd())) { 
            $json = array(
                'error' => 'false',
                'token' => $user->getId()
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
