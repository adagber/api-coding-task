<?php declare(strict_types=1);

namespace Tests\Api\User;

use Tests\ApiTestCase;

final class ProfileTest extends ApiTestCase
{
    public function testGetUserProfile()
    {
        $data = $this->requestJsonWithAuth('user@gmail.com', 'GET', '/users/profile');
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('registered_at', $data);
        $this->assertEquals('user@gmail.com', $data['email']);
    }
}