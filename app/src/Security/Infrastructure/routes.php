<?php declare(strict_types=1);

use App\Security\Infrastructure\Controllers\LoginUserController;
use App\Security\Infrastructure\Controllers\ProfileUserController;
use App\Security\Infrastructure\Middlewares\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

/** @var \Slim\App $app */
$app->group('/users', function (RouteCollectorProxy $group){

    $authMiddleware = $this->get(AuthMiddleware::class);

    $group->post('/login', LoginUserController::class)->setName('app_user_login');
    $group->get('/profile', ProfileUserController::class)
        ->setName('app_user_profile')
        ->add($authMiddleware)
    ;

});
