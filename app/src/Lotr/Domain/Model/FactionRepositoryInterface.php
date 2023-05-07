<?php

namespace App\Lotr\Domain\Model;

use App\Lotr\Application\DTO\FactionDto;

interface FactionRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function create(FactionDto $data): Faction;

    public function update(Faction $factions, FactionDto $data): Faction;

    public function patch(Faction $factions, FactionDto $data): Faction;

    public function delete(Faction $factions): void;

    public function save(Faction $faction);
}