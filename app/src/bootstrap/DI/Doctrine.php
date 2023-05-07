<?php declare(strict_types=1);

namespace App\bootstrap\DI;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\ServiceProvider;

/**
 * A ServiceProvider for registering services related to
 * Doctrine in a DI container.
 *
 * If the project had custom repositories (e.g. UserRepository)
 * they could be registered here.
 */
final class Doctrine implements ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function provide(ContainerInterface $container): void
    {

        $container->set(EntityManagerInterface::class, static function (ContainerInterface $container): EntityManagerInterface {

            /** @var array $settings */
            $settings = $container->get('settings');

            // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
            // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
            $cache = $settings['doctrine']['dev_mode'] ?
                new ArrayAdapter() :
                new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']);

            $config = ORMSetup::createXMLMetadataConfiguration(
                paths: $settings['doctrine']['metadata_dirs'],
                isDevMode: $settings['doctrine']['dev_mode'],
                cache: $cache
            );

            $dsnParser = new DsnParser([
                'mysql' => 'pdo_mysql',
                'postgres' => 'pdo_pgsql'
            ]);
            $connectionParams = $dsnParser
                ->parse($settings['doctrine']['connection']['dsn']);

            // configuring the database connection
            $connection = DriverManager::getConnection($connectionParams, $config);
            return new EntityManager($connection, $config);
        });
    }
}