<?php declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

/** @var \Slim\App $app */
$app->get('/', function (Request $request, Response $response, $args) {

    $data = json_encode([
        "message" => "Hola Mundo"
    ], JSON_PRETTY_PRINT);
    $response->getBody()->write($data);
    return $response->withHeader('Content-Type', 'application/json');;
});