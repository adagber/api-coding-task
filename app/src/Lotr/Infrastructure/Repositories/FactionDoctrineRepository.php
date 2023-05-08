<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Repositories;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Domain\Model\Faction;
use App\Lotr\Domain\Model\FactionRepositoryInterface;
use Doctrine\ORM\EntityRepository;

final class FactionDoctrineRepository extends EntityRepository implements FactionRepositoryInterface
{
    public function create(CreateFactionDto $data): Faction
    {
        return new Faction(
            $data->getFactionName(),
            $data->getDescription(),
            $data->getLeader()
        );
    }

    public function update(Faction $faction, CreateFactionDto $data): Faction
    {
        return $faction->updateFromDto($data);
    }

    public function patch(Faction $faction, CreateFactionDto $data): Faction
    {
        return $faction->patchFromDto($data);
    }

    public function save(Faction $faction): void
    {
        $this->getEntityManager()->persist($faction);
        $this->getEntityManager()->flush($faction);
    }


    public function delete(Faction $factions): void
    {
        $this->getEntityManager()->remove($factions);
        $this->getEntityManager()->flush();
    }
}