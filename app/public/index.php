<?php declare(strict_types=1);

use App\Lotr\Infrastructure\bootstrap\BootstrapApp;

require_once __DIR__ . '/../vendor/autoload.php';

$app = BootstrapApp::getApp();
$app->run();