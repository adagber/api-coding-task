<?php declare(strict_types=1);

namespace App\Security\Application\Services;

use App\Security\Application\DTO\LoginDto;
use App\Security\Application\Exceptions\UserNotFoundException;
use App\Security\Domain\Auth\AuthenticatorInterface;
use App\Security\Domain\Model\UserRepositoryInterface;

final class UserService
{

    public function __construct(
        private AuthenticatorInterface $auth,
        private UserRepositoryInterface $repository
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function login(LoginDto $dto): string
    {
        $user = $this->auth->auth($dto->getEmail(), $dto->getPassword());

        if(!$user){

            throw new UserNotFoundException('User not found');
        }

        return $this->auth->encode($user);
    }
}