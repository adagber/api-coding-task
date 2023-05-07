<?php declare(strict_types=1);

namespace App\Lotr\Domain\Model;

final class Character
{
    private int $id;

    public function __construct(

        private string $name,
        private \DateTimeImmutable $birthDate,
        private string $kingdom,
        private Equipment $equipment,
        private Faction $faction
    ){

    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}