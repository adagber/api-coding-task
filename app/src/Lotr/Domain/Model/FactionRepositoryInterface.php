<?php

namespace App\Lotr\Domain\Model;

use App\Lotr\Application\DTO\CreateFactionDto;

interface FactionRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function create(CreateFactionDto $data): Faction;

    public function update(Faction $factions, CreateFactionDto $data): Faction;

    public function patch(Faction $factions, CreateFactionDto $data): Faction;

    public function delete(Faction $factions): void;

    public function save(Faction $faction);
}