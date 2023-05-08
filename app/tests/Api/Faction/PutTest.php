<?php declare(strict_types=1);

namespace Tests\Api\Faction;

use Doctrine\ORM\EntityManagerInterface;
use Tests\ApiTestCase;

final class PutTest extends ApiTestCase
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

    public function testPutFactions()
    {
        $faction = $this->getOneFaction();

        $data = $this->requestJsonWithAuth('admin@gmail.com', 'PUT', '/factions/'.$faction->getId(), [], [
            'factionName' => 'My test faction name',
            'description' => 'Lorem ipsum...',
            'leader' => 'follow the leader'
        ]);

        $this->assertNull($data);
        $this->assertEquals(204, $this->getLastResponse()->getStatusCode());
    }

    public function testInvalidPutFactions()
    {

        $faction = $this->getOneFaction();

        $data = $this->requestJsonWithAuth('admin@gmail.com', 'PUT', '/factions/'.$faction->getId(), [], [
            'factionName' => 'My test faction name',
            'description' => 'Lol'
        ]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('description', $data['errors']);
        $this->assertArrayHasKey('leader', $data['errors']);
        $this->assertEquals('Invalid data', $data['message']);
        $this->assertEquals('Your description must be at least 5 characters long', $data['errors']['description']);
        $this->assertEquals('This value should not be blank.', $data['errors']['leader']);

        $response = $this->getLastResponse();

        $this->assertEquals(422, $response->getStatusCode());
    }
}