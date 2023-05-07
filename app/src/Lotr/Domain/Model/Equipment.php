<?php declare(strict_types=1);

namespace App\Lotr\Domain\Model;

final class Equipment
{

    private int $id;

    public function __construct(

        private string $name,
        private string $type,
        private string $madeBy,
        private Character $character
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