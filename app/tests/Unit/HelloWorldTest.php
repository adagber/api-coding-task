<?php declare(strict_types=1);

use App\Lotr\Infrastructure\bootstrap\BootstrapApp;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class HelloWorldTest extends TestCase
{

    public function testHelloWorld()
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/');
        $response = BootstrapApp::getApp()->handle($request);
        $body = (string) $response->getBody();

        $data = json_decode($body, true);
        $this->assertIsArray($data);

        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Hola Mundo', $data['message']);
    }
}