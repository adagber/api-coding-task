<?php

use App\bootstrap\BootstrapApp;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

require_once __DIR__ . '/../vendor/autoload.php';

$app = BootstrapApp::getApp('test');
$container = $app->getContainer();
$entityManager = $container->get(EntityManagerInterface::class);

$tool = new SchemaTool($entityManager);
$metadata = $entityManager->getMetadataFactory()->getAllMetadata();
$tool->dropSchema($metadata);
$tool->createSchema($metadata);

$conn = $entityManager->getConnection();

$loader = new Loader();
$loader->loadFromDirectory(__DIR__ . '/Fixtures');

$executor = new ORMExecutor($entityManager, new ORMPurger());
$executor->execute($loader->getFixtures());