<?php declare(strict_types=1);

use App\Lotr\Infrastructure\Middlewares\EnableCORSMiddleware;
use App\Lotr\Infrastructure\Middlewares\JsonFormatMiddleware;

/** @var \Slim\App $app */
$app->add(new JsonFormatMiddleware());
$app->add(new EnableCORSMiddleware());