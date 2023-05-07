<?php declare(strict_types=1);

namespace Tests\Api\Faction;

use Tests\ApiTestCase;

final class ListTest extends ApiTestCase
{
    public function testListFactions()
    {
        $data = $this->requestJson('GET', '/factions');
        $this->assertCount(2, $data);

        $this->assertIsArray($data[0]);

        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('faction_name', $data[0]);
        $this->assertArrayHasKey('description', $data[0]);
        $this->assertArrayHasKey('leader', $data[0]);
    }
}