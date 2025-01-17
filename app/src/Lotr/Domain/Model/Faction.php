<?php declare(strict_types=1);

namespace App\Lotr\Domain\Model;

use App\Lotr\Application\DTO\CreateFactionDto;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Faction'
)]
class Faction implements \JsonSerializable
{

    #[OA\Property()]
    private int $id;

    public function __construct(

        #[OA\Property()]
        private string $factionName,
        #[OA\Property()]
        private string $description,
        #[OA\Property(
            description: 'The leader who is followed by the inhabitants of the faction'
        )]
        private string $leader
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

    public function updateFromDto(CreateFactionDto $dto): self
    {
        $this->factionName = $dto->getFactionName();
        $this->description = $dto->getDescription();
        $this->leader = $dto->getLeader();

        return $this;
    }

    public function patchFromDto(CreateFactionDto $dto): self
    {
        if(null !== $dto->getFactionName()){
            $this->factionName = $dto->getFactionName();
        }


        if(null !== $dto->getDescription()) {
            $this->description = $dto->getDescription();
        }

        if(null !== $dto->getLeader()) {
            $this->leader = $dto->getLeader();
        }

        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'faction_name' => $this->factionName,
            'description' => $this->description,
            'leader' => $this->leader
        ];
    }
}

