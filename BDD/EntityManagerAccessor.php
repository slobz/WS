<?php

namespace BDD;

require_once 'ConfBdd.php';
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityManagerAccessor {

    static function getEntityManager() {
        $bddConf = new ConfBdd();
        
        $paths = array("../Entity");
        $config = Setup::createAnnotationMetadataConfiguration($paths,$bddConf->getIsDevMode());
        return EntityManager::create($bddConf->getDbParams(), $config);
    }

}
