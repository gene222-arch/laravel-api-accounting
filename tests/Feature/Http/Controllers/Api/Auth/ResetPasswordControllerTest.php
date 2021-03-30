<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    /** @test */
    public function user_can_reset_password()
    {
        $data = [
            'email' => 'genephillip222@gmail.com',
            'token' => '',
            'password' => '',
            'password_confirmation' => ''
        ];

        $response = $this->post(
            '/api/forgot-password/reset',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
