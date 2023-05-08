<?php

namespace App\Security\Domain\Auth;

use App\Security\Domain\Model\UserInterface;

interface AuthenticatorInterface
{
    public function decode(string $token): ?UserInterface;

    public function encode(UserInterface $user): string;

    public function auth(string $username, string $password): ?UserInterface;
}