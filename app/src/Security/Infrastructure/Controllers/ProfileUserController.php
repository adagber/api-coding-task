<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Controllers;

use App\Lotr\Infrastructure\Controllers\AbstractController;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProfileUserController extends AbstractController
{

    #[OA\Get(
        path: '/users/profile',
        summary: 'Detail of logged user',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['users'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User profile',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#components/schemas/User'
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
        $user = $request->getAttribute('user');
        return $this->createJsonResponse($user, $response);
    }
}