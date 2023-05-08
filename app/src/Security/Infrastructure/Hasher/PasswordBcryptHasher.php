<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Hasher;

use App\Security\Domain\Model\PasswordHasherInterface;

final class PasswordBcryptHasher implements PasswordHasherInterface
{

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function checkHash(string $plainPassword, string $hash): bool
    {
        return password_verify($plainPassword, $hash);
    }
}