<?php declare(strict_types=1);

namespace Tests;

use App\bootstrap\BootstrapApp;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;
use UMA\DIC\Container;

class ApiTestCase extends TestCase
{
    private Response $lastResponse;

    protected static function getApp(): App
    {
        return BootstrapApp::getApp('test');
    }

    protected static function getContainer(): Container
    {
        return self::getApp()->getContainer();
    }

    protected function getLastResponse(): ?Response
    {
        return $this->lastResponse;
    }

    protected function request(string $method, string $uri, array $headers = [], null|array|object $bodyRequest = null): Response
    {
        $request = (new ServerRequestFactory())->createServerRequest($method, $uri);

        foreach($headers as $keyHeader => $valueHeader){

            $request = $request->withHeader($keyHeader, $valueHeader);
        }

        if($bodyRequest){
            $request = $request->withParsedBody($bodyRequest);
        }

        $this->lastResponse = self::getApp()->handle($request);
        return $this->lastResponse;
    }

    protected function requestBody(string $method, string $uri, array $headers = [], null|array|object $bodyRequest = null): string
    {
        $response = $this->request($method, $uri, $headers, $bodyRequest);
        return (string) $response->getBody();
    }

    protected function requestJson(string $method, string $uri, array $headers = [], null|array|object $bodyRequest = null): ?array
    {

        $body = $this->requestBody($method, $uri, $headers, $bodyRequest);
        return json_decode($body, true);
    }
}