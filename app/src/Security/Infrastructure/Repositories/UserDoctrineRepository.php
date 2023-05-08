<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Repositories;

use App\Security\Domain\Model\User;
use App\Security\Domain\Model\UserInterface;
use App\Security\Domain\Model\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

final class UserDoctrineRepository extends EntityRepository implements UserRepositoryInterface
{
    public function create(string $email, string $hash, ?array $roles): User
    {
        $user = new User($email, $hash, $roles);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    public function findOneByUsername(string $username): ?UserInterface
    {
        return $this->findOneBy(['email' => $username]);
    }
}