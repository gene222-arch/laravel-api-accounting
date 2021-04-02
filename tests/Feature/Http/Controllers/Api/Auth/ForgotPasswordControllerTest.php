<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    /** test */
    public function user_can_request_forgot_password_via_email()
    {
        $data = [
            'email' => 'genephillip222@gmail.com'
        ];

        $response = $this->post(
            '/api/forgot-password/email',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
