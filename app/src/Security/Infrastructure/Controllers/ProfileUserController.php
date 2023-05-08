<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Controllers;

use App\Lotr\Infrastructure\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProfileUserController extends AbstractController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $user = $request->getAttribute('user');
        return $this->createJsonResponse($user, $response);
    }
}