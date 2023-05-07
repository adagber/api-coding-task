<?php declare(strict_types=1);

namespace App\Lotr\Application\DTO;

final class CreateFactionDto
{

    private $factionName;
    private $description;
    private $leader;

    use LoadDataFromArrayTrait;

    public function __construct()
    {

    }

    public function getFactionName(): ?string
    {
        return $this->factionName;
    }

    public function setFactionName($factionName): FactionDto
    {
        $this->factionName = $factionName;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): FactionDto
    {
        $this->description = $description;
        return $this;
    }

    public function getLeader(): ?string
    {
        return $this->leader;
    }

    public function setLeader($leader): FactionDto
    {
        $this->leader = $leader;
        return $this;
    }
}