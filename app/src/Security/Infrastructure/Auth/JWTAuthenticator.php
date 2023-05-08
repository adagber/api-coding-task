<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Auth;


use App\Security\Domain\Auth\AuthenticatorInterface;
use App\Security\Domain\Model\PasswordHasherInterface;
use App\Security\Domain\Model\UserInterface;
use App\Security\Domain\Model\UserRepositoryInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class JWTAuthenticator implements AuthenticatorInterface
{

    private const KEY_ALG = 'HS256';

    public function __construct(
        private string $secret,
        private string $issuer,
        private int $expiresAt,
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher
    )
    {

    }

    public function decode(string $token): ?UserInterface
    {
        $token = str_replace('Bearer ', '', $token);
        try{
            $decoded = JWT::decode($token, new Key($this->secret, self::KEY_ALG));
            return $this->userRepository->findOneByUsername($decoded->username);
        } catch (\Exception $e){

            return null;
        }
    }

    public function encode(UserInterface $user): string
    {
        $payload = [
            'iss' => $this->issuer,
            'iat' => time(),
            'exp' => time() + $this->expiresAt,
            'username' => $user->getUsername()
        ];
        return JWT::encode($payload, $this->secret, self::KEY_ALG);
    }

    public function auth(string $username, string $password): ?UserInterface
    {
        //Get the user by username
        $user = $this->userRepository->findOneByUsername($username);
        if(!$user){

            return null;
        }

        //Check credentials
        if(!$user->authenticate($password, $this->passwordHasher)){

            return null;
        }

        return $user;
    }
}