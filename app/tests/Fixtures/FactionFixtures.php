<?php declare(strict_types=1);

namespace Tests\Fixtures;

use App\Lotr\Domain\Model\Faction;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class FactionFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faction1 = new Faction(
            'Hobbiton',
            'Aldea Hobbit ubicada en la comarca',
            'Gandalf'
        );
        $manager->persist($faction1);
        $faction2 = new Faction(
            'MORDOR',
            'Mordor es un país situado al sureste de la Tierra Media, que tuvo gran importancia durante la Guerra del Anillo por ser el lugar donde Sauron, el Señor Oscuro, decidió edificar su fortaleza de Barad-dûr para intentar atacar y dominar a todos los pueblos de la Tierra Media.',
            'Sauron'
        );

        $manager->persist($faction2);
        $manager->flush();
    }
}