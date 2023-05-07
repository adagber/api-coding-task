<?php declare(strict_types=1);

use App\bootstrap\BootstrapApp;

require_once __DIR__ . '/../vendor/autoload.php';

$app = BootstrapApp::getApp();
$app->run();