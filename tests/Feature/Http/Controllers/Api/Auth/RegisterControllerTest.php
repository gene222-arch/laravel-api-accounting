<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{

    /** @test */
    public function user_can_register()
    {
        $data = [
            'first_name' => 'Gene Phillip',
            'last_name' => 'Artista',
            'email' => 'genephillip222@gmail.com',
            'password' => 'administrator',
            'password_confirmation' => 'administrator'
        ];

        $response = $this->post(
            '/api/auth/register', 
            $data, 
            $this->apiHeader());

        $this->assertResponse($response);
    }
}
