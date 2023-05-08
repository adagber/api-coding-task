<?php declare(strict_types=1);

use App\Lotr\Infrastructure\Controllers\ListFactionController;
use App\Lotr\Infrastructure\Controllers\ShowFactionController;
use App\Lotr\Infrastructure\Controllers\CreateFactionController;
use App\Lotr\Infrastructure\Controllers\UpdateFactionController;
use App\Lotr\Infrastructure\Controllers\PartialUpdateFactionController;
use App\Lotr\Infrastructure\Controllers\DeleteFactionController;
use App\Security\Infrastructure\Middlewares\AuthMiddleware;
use App\Lotr\Infrastructure\Middlewares\CacheMiddleware;
use App\Security\Infrastructure\Middlewares\FirewallMiddleware;

use Slim\Routing\RouteCollectorProxy;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/** @var \Slim\App $app */

$app->group('/factions', function (RouteCollectorProxy $group){

    $authMiddleware = $this->get(AuthMiddleware::class);
    $cacheAdapter = $this->get(AdapterInterface::class);

    $group->group('', function (RouteCollectorProxy $group) {
        $group->get('', ListFactionController::class)->setName('app_factions_list');
        $group->get('/{id:[0-9]+}', ShowFactionController::class)->setName('app_factions_show');
    })
        ->add(new CacheMiddleware($cacheAdapter, 'factions'))
    ;

    $group->group('', function (RouteCollectorProxy $group) {

        $group->post('', CreateFactionController::class)->setName('app_factions_create');
        $group->put('/{id:[0-9]+}', UpdateFactionController::class)->setName('app_factions_update');
        $group->patch('/{id:[0-9]+}', PartialUpdateFactionController::class)->setName('app_factions_patch');
        $group->delete('/{id:[0-9]+}', DeleteFactionController::class)->setName('app_factions_delete');
    })
        ->add(new CacheMiddleware($cacheAdapter, 'factions'))
        ->add(new FirewallMiddleware(['ROLE_ADMIN']))
        ->add($authMiddleware)
    ;
});
