<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListFactionController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');
        return $this->createJsonResponse(['message' => 'Hola mundo'], $response);
    }
}