<?php declare(strict_types=1);

namespace App\Lotr\Application\DTO;

final class ShowFactionDto
{

    static public function create($id): self
    {
        return new self($id);
    }

    public function __construct(private $id)
    {

    }

    public function getId()
    {
        return $this->id;
    }
}