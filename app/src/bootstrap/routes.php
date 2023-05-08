<?php declare(strict_types=1);

use OpenApi\Generator;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

#[OA\Info(
    version: '1.0',
    title: 'Lotr API'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    name: 'Authorization',
    bearerFormat: 'JWT',
    scheme: 'bearer'
)]
class OpenApi {}

/** @var \Slim\App $app */
$app->get('/', function (Request $request, Response $response, $args) {

    $data = json_encode([
        "message" => "Hola Mundo"
    ], JSON_PRETTY_PRINT);
    $response->getBody()->write($data);
    return $response->withHeader('Content-Type', 'application/json');;
});

$app->get('/docs', function (Request $request, Response $response, $args) {

    $swagger = Generator::scan([__DIR__ . '/../']);

    $response->getBody()->write($swagger->toYaml());
    return $response->withHeader('Content-Type', 'application/x-yaml');
});

