<?php declare(strict_types=1);

namespace App\Lotr\Application\Services;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\DTO\DeleteFactionDto;
use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Application\DTO\ShowFactionDto;
use App\Lotr\Application\Exceptions\FactionNotFoundException;
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
        return $this->repository->find($dto->getId());
    }

    /**
     * @throws FactionNotFoundException
     */
    public function update(mixed $id, CreateFactionDto $dto): Faction
    {

        $faction = $this->repository->find($id);

        if(!$faction){
            throw new FactionNotFoundException('Faction not found');
        }

        $updatedFaction = $this->repository->update($faction, $dto);
        $this->repository->save($updatedFaction);

        return $updatedFaction;
    }

    /**
     * @throws FactionNotFoundException
     */
    public function patch(mixed $id, CreateFactionDto $dto): Faction
    {
        $faction = $this->repository->find($id);

        if(!$faction){
            throw new FactionNotFoundException('Faction not found');
        }

        $patchedFaction = $this->repository->patch($faction, $dto);
        $this->repository->save($patchedFaction);

        return $patchedFaction;
    }

    /**
     * @throws FactionNotFoundException
     */
    public function delete(DeleteFactionDto $dto): void
    {
        $faction = $this->repository->find($dto->getId());

        if(!$faction){
            throw new FactionNotFoundException('Faction not found');
        }

        $this->repository->delete($faction);
    }
}