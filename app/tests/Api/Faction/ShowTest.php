<?php declare(strict_types=1);

namespace Tests\Api\Faction;

use Tests\ApiTestCase;

final class ShowTest extends ApiTestCase
{

    use FactionTrait;

    public function testShowFactions()
    {

        $faction = $this->getOneFaction();
        $data = $this->requestJson('GET', '/factions/'.$faction->getId());

        $this->assertIsArray($data);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('faction_name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('leader', $data);
    }
}