<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class EnableCORSMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $request = $request->withHeader('Accept', 'application/json');

        $response = $handler->handle($request);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        ;

        return $response;
    }
}