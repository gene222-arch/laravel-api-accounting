<?php

namespace Tests\Feature\Http\Controllers\Api\AccessRight;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccessRightsControllerTest extends TestCase
{
    /** test */
    public function user_can_view_any_access_rights()
    {
        $response = $this->get(
            '/api/access-rights',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_access_right()
    {
        $id = 1;

        $response = $this->get(
            "/api/access-rights/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_access_right()
    {
        $data = [
            'role' => 'Admin',
            'permissions' => [
                'View Dashboard'
            ]
        ];

        $response = $this->post(
            '/api/access-rights',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response, 201);
    }

    /** test */
    public function user_can_update_access_right()
    {
        $data = [
            'roleId' => 1,
            'role' => 'Super Duper Admin',
            'permissions' => [
                'View Dashboard',
            ]
        ];

        $response = $this->put(
            '/api/access-rights',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response, 201);
    }

    /** test */
    public function user_can_delete_access_rights()
    {
        $data = [
            'roleIds' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/access-rights',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
