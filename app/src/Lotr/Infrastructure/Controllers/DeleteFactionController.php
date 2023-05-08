<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\DeleteFactionDto;
use App\Lotr\Application\Exceptions\FactionNotFoundException;
use App\Lotr\Application\Services\FactionService;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class DeleteFactionController extends AbstractController
{

    #[OA\Delete(
        path: '/factions/{id}',
        description: 'Delete the faction',
        summary: 'Delete the faction',
        security: [
            ['bearerAuth' => []]
        ],
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
                response: 204,
                description: 'Created without content response'
            ),
            new OA\Response(
                response: 404,
                description: 'Not found'
            )
        ]
    )]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = DeleteFactionDto::create($args['id']);
        $service = $this->container->get(FactionService::class);

        try {
            $service->delete($dto);
        } catch (FactionNotFoundException $exc){

            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $response->withStatus(204);
    }
}