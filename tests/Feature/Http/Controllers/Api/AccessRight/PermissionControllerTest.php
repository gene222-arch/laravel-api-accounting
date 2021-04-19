<?php

namespace Tests\Feature\Http\Controllers\Api\AccessRight;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionControllerTest extends TestCase
{
    /** test */
    public function user_can_view_any_permissions()
    {
        $response = $this->get(
            '/api/access-rights/permissions',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
