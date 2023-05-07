<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{

    public function __construct(protected ContainerInterface $container)
    {

    }

    public function createJsonResponse(mixed $data, ResponseInterface $response, ?int $statusCode = null): ResponseInterface
    {
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        if($statusCode){
            $response = $response->withStatus($statusCode);
        }
        return $response;
    }

    public function createInvalidDataResponse(array $errors, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode([
            'message' => 'Invalid data',
            'errors' => $errors
        ], JSON_PRETTY_PRINT));

        return $response->withStatus(422);
    }
}