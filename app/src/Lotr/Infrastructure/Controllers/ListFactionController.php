<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Application\Services\FactionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListFactionController extends AbstractController
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $service = $this->container->get(FactionService::class);
        $factions = $service->list(ListFactionDto::create());

        return $this->createJsonResponse($factions, $response);
    }
}