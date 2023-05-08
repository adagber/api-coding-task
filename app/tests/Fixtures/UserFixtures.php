<?php declare(strict_types=1);

namespace Tests\Fixtures;


use App\Security\Domain\Model\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $user = new User(
            'user@gmail.com',
            '$2y$10$QiRR7kDPO/bQOoeUiN.1TeKKgK9Bqksb2Ph1sVY7oe.fcU9559sTe', //Password -> 1234
            ['ROLE_USER']
        );
        $manager->persist($user);
        $admin = new User(
            'admin@gmail.com',
            '$2y$10$QiRR7kDPO/bQOoeUiN.1TeKKgK9Bqksb2Ph1sVY7oe.fcU9559sTe', //Password -> 1234
            ['ROLE_ADMIN']
        );
        $manager->persist($admin);
        $manager->flush();
    }
}