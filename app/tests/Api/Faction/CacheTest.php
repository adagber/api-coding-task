<?php declare(strict_types=1);

namespace Tests\Api\Faction;

use Doctrine\ORM\EntityManagerInterface;
use Tests\ApiTestCase;

final class CacheTest extends ApiTestCase
{

    public function setUp(): void
    {
        $settings = self::getContainer()->get('settings');
        $this->removeDir($settings['cache']['filesystem_adapter']['directory']);

        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $em->beginTransaction();
    }
    public function testCache()
    {
        $data = $this->requestJson('GET', '/factions');
        $this->assertFalse($this->getLastResponse()->hasHeader('X-Cache'));

        $data = $this->requestJson('GET', '/factions');
        $this->assertTrue($this->getLastResponse()->hasHeader('X-Cache'));

        $data = $this->requestJsonWithAuth('admin@gmail.com', 'POST', '/factions', [], [
            'factionName' => 'My test faction name',
            'description' => 'Lorem ipsum...',
            'leader' => 'follow the leader'
        ]);

        $data = $this->requestJson('GET', '/factions');
        $this->assertFalse($this->getLastResponse()->hasHeader('X-Cache'));

    }

    public function tearDown(): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $em->rollback();
    }
}