<?php declare(strict_types=1);

namespace Tests\Api\User;

use Tests\ApiTestCase;

final class LoginTest extends ApiTestCase
{
    public function testLoginUser()
    {
        $data = $this->requestJson('POST', '/users/login', [], [
            'email' => 'user@gmail.com',
            'password' => '1234'
        ]);

        $this->assertEquals(200, $this->getLastResponse()->getStatusCode());
        $this->assertIsArray($data);
        $this->assertArrayHasKey('token', $data);
    }
}