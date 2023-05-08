<?php

namespace App\Security\Domain\Model;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;

    public function checkHash(string $plainPassword, string $hash): bool;
}