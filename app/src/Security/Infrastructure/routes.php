<?php declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

/** @var \Slim\App $app */

$app->group('/users', function (RouteCollectorProxy $group){

    //$group->post('login', LoginUserController::class)->setName('app_user_login');
    //$group->get('profile', ProfileUserController::class)->setName('app_user_profile');

});
