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
            '/api/item/discounts',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_discount()
    {
        $id = 1;

        $response = $this->get(
            "/api/item/discounts/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_discount()
    {
        $data = [
            'name' => 'Discount 3',
            'rate' => 10,
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/item/discounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_discount()
    {
        $id = 3;

        $data = [
            'id' => 3,
            'name' => 'New discount',
            'rate' => 25,
            'enabled' => true,
        ];

        $response = $this->put(
            "/api/item/discounts/${id}",
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
            '/api/item/discounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
