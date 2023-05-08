<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\ShowFactionDto;
use App\Lotr\Application\Services\FactionService;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class ShowFactionController extends AbstractController
{

    #[OA\Get(
        path: '/factions/{id}',
        summary: 'Detail of faction',
        tags: ['factions'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                schema: new OA\Schema(
                    type: 'integer'
                )
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Not allowed',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#components/schemas/Faction'
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Not found'
            ),
        ]
    )]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = ShowFactionDto::create($args['id']);
        $service = $this->container->get(FactionService::class);
        $faction = $service->show($dto);
        if(!$faction){
            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $this->createJsonResponse($faction, $response);
    }
}