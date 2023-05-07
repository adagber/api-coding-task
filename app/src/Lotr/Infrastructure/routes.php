<?php declare(strict_types=1);

use App\Lotr\Infrastructure\Controllers\ListFactionController;

use Slim\Routing\RouteCollectorProxy;

/** @var \Slim\App $app */

$app->group('/factions', function (RouteCollectorProxy $group){

    $group->get('', ListFactionController::class)->setName('app_factions_list');
});
