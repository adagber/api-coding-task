<?php declare(strict_types=1);

use App\Lotr\Application\Services\FactionService;
use App\Lotr\Domain\Model\Faction;
use App\Lotr\Domain\Model\FactionRepositoryInterface;
use App\Security\Domain\Auth\AuthenticatorInterface;
use App\Security\Domain\Model\User;
use App\Security\Domain\Model\UserRepositoryInterface;
use App\Security\Domain\Model\PasswordHasherInterface;
use \App\Security\Infrastructure\Auth\JWTAuthenticator;
use App\Security\Infrastructure\Hasher\PasswordBcryptHasher;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

/** @var Container $container */
$container->set(FactionRepositoryInterface::class, function(ContainerInterface $container){

    $em = $container->get(EntityManagerInterface::class);
    return $em->getRepository(Faction::class);
});

$container->set(UserRepositoryInterface::class, function(ContainerInterface $container){

    $em = $container->get(EntityManagerInterface::class);
    return $em->getRepository(User::class);
});

$container->set(FactionService::class, function(ContainerInterface $container){

    $factionRepository = $container->get(FactionRepositoryInterface::class);
    return new FactionService($factionRepository);
});

$container->set(PasswordHasherInterface::class, function(ContainerInterface $container){

    return new PasswordBcryptHasher();
});

$container->set(AuthenticatorInterface::class, function(ContainerInterface $container){

    /** @var array $settings */
    $settings = $container->get('settings');

    return new JWTAuthenticator(
        $settings['security']['jwt_secret'],
        $settings['security']['jwt_issuer'],
        $settings['security']['jwt_expires_at'],
        $container->get(UserRepositoryInterface::class),
        $container->get(PasswordHasherInterface::class),
    );
});