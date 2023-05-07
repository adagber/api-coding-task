<?php declare(strict_types=1);

namespace App;

use Slim\App;
use Slim\Factory\AppFactory;

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
        $app = AppFactory::create();

        require_once __DIR__ . '/dependencies.php';
        require_once __DIR__ . '/middlewares.php';
        require_once __DIR__ . '/routes.php';

        return $app;
    }
}