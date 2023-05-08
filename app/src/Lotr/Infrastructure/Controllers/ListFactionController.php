<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\ListFactionDto;
use App\Lotr\Application\Services\FactionService;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListFactionController extends AbstractController
{

    #[OA\Get(
        path: '/factions',
        summary: 'List of factions',
        tags: ['factions'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List the factions of the Middle Earth',
                content: [
                    new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'array',
                            items: new OA\Items(
                                ref: '#components/schemas/Faction'
                            )
                        )
                    )
                ]
            )
        ]
    )]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $service = $this->container->get(FactionService::class);
        $factions = $service->list(ListFactionDto::create());

        return $this->createJsonResponse($factions, $response);
    }
}