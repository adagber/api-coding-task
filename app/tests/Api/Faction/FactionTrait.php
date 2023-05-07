<?php

namespace Tests\Api\Faction;

use App\Lotr\Domain\Model\Faction;
use App\Lotr\Domain\Model\FactionRepositoryInterface;

trait FactionTrait
{
    protected function getOneFaction(): ?Faction
    {
        $repository = self::getContainer()->get(FactionRepositoryInterface::class);

        $factions =  $repository->findAll();

        if(!$factions){

            return null;
        }

        return current($factions);
    }
}