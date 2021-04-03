<?php

namespace Tests\Feature\Http\Controllers\Api\Item\Discount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiscountsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_discounts()
    {
        $response = $this->get(
            '/api/discounts',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_discount()
    {
        $id = 1;

        $response = $this->get(
            "/api/discounts/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_discount()
    {
        $data = [
            'name' => 'Discount 3',
            'rate' => 10
        ];

        $response = $this->post(
            '/api/discounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_discount()
    {
        $data = [
            'id' => 3,
            'name' => 'New discount',
            'rate' => 25
        ];

        $response = $this->put(
            '/api/discounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_discounts()
    {
        $data = [
            'ids' => [
                2,
                3
            ]
        ];

        $response = $this->delete(
            '/api/discounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
