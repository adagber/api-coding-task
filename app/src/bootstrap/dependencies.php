<?php declare(strict_types=1);

use App\Lotr\Application\Services\FactionService;
use App\Lotr\Domain\Model\Faction;
use App\Lotr\Domain\Model\FactionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

/** @var Container $container */
$container->set(FactionRepositoryInterface::class, function(ContainerInterface $container){

    $em = $container->get(EntityManagerInterface::class);
    return $em->getRepository(Faction::class);
});

$container->set(FactionService::class, function(ContainerInterface $container){

    $factionRepository = $container->get(FactionRepositoryInterface::class);
    return new FactionService($factionRepository);
});