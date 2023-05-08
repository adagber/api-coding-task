<?php declare(strict_types=1);

namespace Tests\Api\Faction;

use Doctrine\ORM\EntityManagerInterface;
use Tests\ApiTestCase;

final class DeleteTest extends ApiTestCase
{

    use FactionTrait;

    public function setUp(): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $em->beginTransaction();
    }

    public function tearDown(): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $em->rollback();
    }

    public function testDeleteFactions()
    {

        $faction = $this->getOneFaction();
        $data = $this->requestJsonWithAuth('admin@gmail.com', 'DELETE', '/factions/'.$faction->getId());

        $this->assertNull($data);
        $this->assertEquals(204, $this->getLastResponse()->getStatusCode());
    }
}