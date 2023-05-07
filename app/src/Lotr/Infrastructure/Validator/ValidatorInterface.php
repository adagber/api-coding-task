<?php

namespace App\Lotr\Infrastructure\Validator;

interface ValidatorInterface
{
    public function validate(mixed $value, array $groups = []): array;
}