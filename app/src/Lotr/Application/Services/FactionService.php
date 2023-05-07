<?php declare(strict_types=1);

namespace App\Lotr\Application\Services;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Application\DTO\ShowFactionDto;
use App\Lotr\Domain\Model\Faction;
use App\Lotr\Domain\Model\FactionRepositoryInterface;

final class FactionService
{

    public function __construct(
        private FactionRepositoryInterface $repository
    )
    {
    }

    public function list(ListFactionDto $dto): array
    {
        return $this->repository->findAll();
    }

    public function create(CreateFactionDto $dto): ?Faction
    {
        $faction = $this->repository->create($dto);
        $this->repository->save($faction);

        return $faction;
    }

    public function show(ShowFactionDto $dto): ?Faction
    {
        return $faction = $this->repository->find($dto->getId());
    }
}