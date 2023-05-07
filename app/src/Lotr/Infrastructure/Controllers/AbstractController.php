<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{

    public function __construct(private ContainerInterface $container)
    {

    }

    public function createJsonResponse(mixed $data, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response;
    }
}