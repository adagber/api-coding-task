<?php declare(strict_types=1);

namespace Tests\Api\Factions;

use Doctrine\ORM\EntityManagerInterface;
use Tests\ApiTestCase;

final class PostTest extends ApiTestCase
{
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

    public function testPostFactions()
    {

        $data = $this->requestJson('POST', '/factions', [], [
            'factionName' => 'My test faction name',
            'description' => 'Lorem ipsum...',
            'leader' => 'follow the leader'
        ]);

        $this->assertIsArray($data);

        $this->assertArrayHasKey('faction_name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('leader', $data);
        $this->assertEquals('My test faction name', $data['faction_name']);
        $this->assertEquals('Lorem ipsum...', $data['description']);
        $this->assertEquals('follow the leader', $data['leader']);

        $response = $this->getLastResponse();

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testInvalidPostFactions()
    {

        $data = $this->requestJson('POST', '/factions', [], [
            'description' => 'Lorem ipsum...',
            'leader' => 'follow the leader'
        ]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('factionName', $data['errors']);
        $this->assertEquals('Invalid data', $data['message']);
        $this->assertEquals('This value should not be blank.', $data['errors']['factionName']);

        $response = $this->getLastResponse();

        $this->assertEquals(422, $response->getStatusCode());

        $data = $this->requestJson('POST', '/factions', [], [
            'factionName' => 'My test faction name',
            'description' => 'Lol',
            'leader' => 'follow the leader'
        ]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('description', $data['errors']);
        $this->assertEquals('Invalid data', $data['message']);
        $this->assertEquals('Your description must be at least 5 characters long', $data['errors']['description']);
    }
}