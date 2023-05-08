<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Middlewares;

use App\Domain\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Response;

final class FirewallMiddleware
{
    public function __construct(private array $allowedRoles)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        /** @var User $user */
        $user = $request->getAttribute('user');
        if(!$user){

            throw new HttpUnauthorizedException($request);
        }

        if(!$user->hasAnyRoles($this->allowedRoles)){
            throw new HttpUnauthorizedException($request);
        }

        return $handler->handle($request);
    }
}