<?php declare(strict_types=1);

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\Container;

final class BootstrapApp
{
    private static ?App $instance = null;

    static public function getApp( ?string $env = null): App
    {
        if (!self::$instance) {
            self::$instance = self::init($env);
        }
        return self::$instance;
    }

    static private function init(?string $env): App
    {
        $settingsFile = self::resolveSettingsFile($env);
        $container = new Container(require $settingsFile);

        $container->set(App::class, static function (ContainerInterface $container): App {

            /** @var array $settings */
            $settings = $container->get('settings');

            $app = AppFactory::createFromContainer($container);

            $app->addBodyParsingMiddleware();
            $app->addRoutingMiddleware();
            $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );

            return $app;
        });

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

        $app = $container->get(\Slim\App::class);

        require_once __DIR__ . '/dependencies.php';
        require_once __DIR__ . '/middlewares.php';
        require_once __DIR__ . '/routes.php';

        return $app;
    }

    /**
     * @throws \Exception
     */
    static public function resolveSettingsFile(?string $env): string
    {
        $path = __DIR__ . '/../config';
        $defaultFile = $path.'/settings.php';

        if(!file_exists($defaultFile)){
            throw new \Exception('Missing settings.php file');
        }

        if(!$env){
            return $defaultFile;
        }

        $file = $path.'/settings_'.strtolower($env).'.php';

        return file_exists($file) ? $file : $defaultFile;
        return $path.'/settings.php';
    }
}