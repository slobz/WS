<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'Test/bootstrap.php';

//$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
