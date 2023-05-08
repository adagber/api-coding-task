<?php

namespace App\Security\Domain\Model;

interface UserInterface
{
    public function getUsername(): string;
    public function authenticate(string $password, PasswordHasherInterface $passwordHasher): bool;
    public function changePassword(string $password, PasswordHasherInterface $passwordHasher): void;
}