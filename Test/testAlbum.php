<?php

require_once 'bootstrap.php';
require_once '../Entity/Album/Album.php';

use Entity\Album\Album;

   

$tome = new Album();
$tome->setTotal(15);

//$test = $entityManager->getRepository('Entity\Album\Album');
//$albums = $test->findAll();
//
//
//// Test si album existe ou PAS*
//$nomTome = 'XIII';
//$tome = $test->findOneBy(array('titre' => $nomTome ));
//
//echo '<pre>';
//var_dump($tome);
//echo '</pre>';
//
//$tome->addTomePossede();
//
//echo '<pre>';
//var_dump($tome);
//echo '</pre>';
//
//$test->persist($tome);

