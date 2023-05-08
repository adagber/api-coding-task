<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class CacheMiddleware
{

    public function __construct(private AdapterInterface $cache, private string $prefix = '')
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $cacheKey = $this->createCacheKeyFromRequest($request);

        if($request->getMethod() !== 'GET'){

            //Remove the cache
            $this->cache->clear($this->prefix);
            return $handler->handle($request);
        }

        $cachedResponse = $this->cache->getItem($cacheKey);
        if(!$cachedResponse->isHit()){

            $response = $handler->handle($request);
            $cachedResponse->set((string) $response->getBody());
            $this->cache->save($cachedResponse);

            return $response;
        }

        return $this->createResponseFromCachedContent($cachedResponse->get());
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    private function createCacheKeyFromRequest(Request $request): string
    {
        return $this->prefix.'_'.md5($request->getUri()->getPath() . serialize($request->getQueryParams()));
    }

    private function createResponseFromCachedContent(string $content): Response
    {
        $response = new Response();
        $response->getBody()->write($content);
        return $response->withHeader('X-Cache', 1);
    }
}