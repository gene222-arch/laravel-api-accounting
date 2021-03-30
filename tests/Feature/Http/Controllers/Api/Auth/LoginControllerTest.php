<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /** @test */
    public function user_can_login()
    {
        $data = [
            'email' => 'genephillip222@gmail.com',
            'password' => 'administrator'
        ];

        $response = $this->post('/api/auth/login', $data, $this->apiHeader());

        $this->assertResponse($response);
    }
}
