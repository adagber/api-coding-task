<?php declare(strict_types=1);

namespace App\Security\Infrastructure\Middlewares;

use App\Security\Domain\Auth\AuthenticatorInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;
use Slim\Psr7\Response;

final class AuthMiddleware
{
    public function __construct(
        private AuthenticatorInterface $authenticator
    )
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');
        if(!$token){
            throw new HttpForbiddenException($request);
        }

        $user = $this->authenticator->decode($token);
        if(!$user){
            throw new HttpForbiddenException($request);
        }

        $request = $request->withAttribute('user', $user);

        return $handler->handle($request);
    }
}