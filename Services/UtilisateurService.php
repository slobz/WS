<?php

namespace Services;

require_once 'Service.php';
require_once 'Entity/IF26/Utilisateur.php';

use Tools;
use Entity\IF26\Utilisateur;

class UtilisateurService extends Service {

    public function __construct($em) {
        parent::__construct($em);
    }

    //@override
    public function add() {
        
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
            $repo = $this->entityManager->getRepository(Service::ENTIT_UTILISATEUR);
            $user = $repo->findOneBy(array('login' => $login));

            if (empty($user)) { // Login inconnu
                $json = array(
                    'error' => true,
                    'libelleError' => 'Login inconnu'
                );
            } else { // Connection
                $json = $this->connection($user, $pwd);
            }
        }

        return json_encode($json);
    }

    private function connection($user, $pwd) {
        
        if ($user->getPwd() == $pwd) {
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