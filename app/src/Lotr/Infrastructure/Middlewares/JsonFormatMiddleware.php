<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class JsonFormatMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $request = $request->withHeader('Accept', 'application/json');
        $response = $handler->handle($request);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}