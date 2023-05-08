<?php

namespace App\Security\Domain\Model;

interface UserRepositoryInterface
{
    public function findOneByUsername(string $username): ?UserInterface;
}