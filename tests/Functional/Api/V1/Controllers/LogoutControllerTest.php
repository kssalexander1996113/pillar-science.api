<?php

namespace App\Functional\Api\V1\Controllers;

use App\Models\User;
use App\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $user = new User([
            'name' => 'Test',
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $user->save();
    }

    public function testLogout()
    {
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200);

        $responseJSON = json_decode($response->getContent(), true);
        $token = $responseJSON['token'];

        $this->post('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ])->assertStatus(200);

        $this->post('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token
        ])->assertStatus(401);
    }
}
