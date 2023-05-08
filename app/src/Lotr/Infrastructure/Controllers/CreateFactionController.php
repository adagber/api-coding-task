<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\Services\FactionService;
use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateFactionController extends AbstractController
{

    #[OA\Post(
        path: '/factions',
        description: 'Create a new faction',
        summary: 'Create a new faction',
        security: [
            ['bearerAuth' => []]
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    ref: '#components/schemas/FactionDto'
                )
            )
        ),
        tags: ['factions'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Created',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#components/schemas/Faction'
                    )
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Error in validation data'
            ),
        ]
    )]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = CreateFactionDto::createFromArray($request->getParsedBody());
        $validator = $this->container->get(ValidatorInterface::class);
        $errors = $validator->validate($dto, ['create']);

        if (count($errors) > 0) {
            return $this->createInvalidDataResponse($errors, $response);
        }

        $service = $this->container->get(FactionService::class);
        $faction = $service->create($dto);

        return $this->createJsonResponse($faction, $response, 201);
    }
}