<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Controllers;

use App\Lotr\Application\DTO\CreateFactionDto;
use App\Lotr\Application\Exceptions\FactionNotFoundException;
use App\Lotr\Application\Services\FactionService;
use App\Lotr\Infrastructure\Validator\ValidatorInterface;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class PartialUpdateFactionController extends AbstractController
{

    #[OA\Patch(
        path: '/factions/{id}',
        description: 'Partial Update the faction',
        summary: 'Update the partial data faction. The data missing will not be saved',
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
        $errors = $validator->validate($dto, ['patch']);

        if (count($errors) > 0) {
            return $this->createInvalidDataResponse($errors, $response);
        }

        $service = $this->container->get(FactionService::class);

        try {
            $service->patch($args['id'], $dto);
        } catch (FactionNotFoundException $exc){

            throw new HttpNotFoundException($request, 'Faction not found');
        }

        return $response->withStatus(204);
    }
}