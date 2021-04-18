<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailVerificationControllerTest extends TestCase
{
    /** test */
    public function user_can_resend_email_verification()
    {
        $response = $this->get(
            "/api/email/resend",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }
}
