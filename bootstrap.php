<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

$paths = array(__DIR__ . '/src');
$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

try {
    $entityManager = EntityManager::create($connection, $config);
} catch (ORMException $exception) {
    echo $exception->getMessage() . PHP_EOL;
    die;
}