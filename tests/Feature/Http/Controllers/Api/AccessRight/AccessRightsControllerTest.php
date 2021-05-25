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

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_access_right()
    {
        $id = 12;

        $response = $this->get(
            "/api/access-rights/${id}/show",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_access_right()
    {
        $data = [
            'role' => 'Manager',
            'permissions' => [1],
            'enabled' => true
        ];

        $response = $this->post(
            '/api/access-rights',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_update_access_right()
    {
        $id = 5;

        $data = [
            'id' => 5,
            'role' => 'Super Duper Manager',
            'permissions' => [1, 2],
            'enabled' => true
        ];

        $response = $this->put(
            "/api/access-rights/${id}",
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_access_rights()
    {
        $data = [
            'ids' => [
                4
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
