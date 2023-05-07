<?php declare(strict_types=1);

namespace App\Lotr\Application\DTO;

final class NullValue implements ValuableInterface
{
    static public function create(): self
    {
        return new self();
    }

    public function getValue(): mixed
    {
        return null;
    }

    public function __toString(): string
    {
        return '';
    }
}