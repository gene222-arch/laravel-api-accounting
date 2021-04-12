<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\Contribution;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContributionsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_contributions()
    {
        $response = $this->get(
            '/api/settings/contributions',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_contribution()
    {
        $id = 1;

        $response = $this->get(
            "/api/settings/contributions/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_contribution()
    {
        $data = [
            'name' => 'S',
            'rate' => 9,
            'enabled' => false
        ];

        $response = $this->post(
            '/api/settings/contributions',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_contribution()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'Pag ibigs',
            'rate' => 2,
            'enabled' => true
        ];

        $response = $this->put(
            "/api/settings/contributions/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_contributions()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/settings/contributions',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
