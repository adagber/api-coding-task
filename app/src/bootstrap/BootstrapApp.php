<?php declare(strict_types=1);

namespace App\bootstrap;

use App\bootstrap\DI\Doctrine;
use App\bootstrap\DI\Slim;
use Slim\App;
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

        $container->register(new Slim());
        $container->register(new Doctrine());

        $app = $container->get(App::class);

        require_once __DIR__ . '/dependencies.php';
        require_once __DIR__ . '/middlewares.php';
        require_once __DIR__ . '/routes.php';
        require_once __DIR__ . '/../Lotr/Infrastructure/routes.php';
        require_once __DIR__ . '/../Security/Infrastructure/routes.php';

        return $app;
    }

    /**
     * @throws \Exception
     */
    static public function resolveSettingsFile(?string $env): string
    {
        $path = __DIR__ . '/../..';
        $defaultFile = $path.'/settings.php';

        if(!file_exists($defaultFile)){
            throw new \Exception('Missing settings.php file');
        }

        if(!$env){
            return $defaultFile;
        }

        $file = $path.'/settings_'.strtolower($env).'.php';

        return file_exists($file) ? $file : $defaultFile;
    }
}