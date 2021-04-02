<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    /** test */
    public function user_can_view_authenticated_user()
    {
        $response = $this->get(
            '/api/auth',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }


}
