<?php


require_once "../vendor/autoload.php";
require_once "conf.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("../Entity");
$isDevMode = false;

// the connection configuration

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);