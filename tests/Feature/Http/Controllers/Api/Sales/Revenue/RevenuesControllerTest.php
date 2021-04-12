<?php

namespace Tests\Feature\Http\Controllers\Api\Sales\Revenue;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RevenuesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_revenues()
    {
        $response = $this->get(
            '/api/sales/revenues',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_revenue()
    {
        $id = 1;

        $response = $this->get(
            "/api/sales/revenues/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_revenue()
    {
        $data = [
            'date' => '2021-05-03',
            'amount' => 120.00,
            'recurring' => 'No',

            'account_id' => 1,
            'customer_id' => 1,
            'income_category_id' => 1,
            'payment_method_id' => 1,
            'currency_id' => 1,
        ];

        $response = $this->post(
            '/api/sales/revenues',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_revenue()
    {
        $id = 4;

        $data = [
            'id' => 4,
            'date' => '2021-05-03',
            'amount' => 140.00,
            'recurring' => 'Daily',
            'account_id' => 1,
            'customer_id' => 1,
            'income_category_id' => 1,
            'payment_method_id' => 1,
            'currency_id' => 1,
        ];

        $response = $this->put(
            "/api/sales/revenues/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_revenues()
    {
        $data = [
            'ids' => [
                4,
                5
            ]
        ];

        $response = $this->delete(
            '/api/sales/revenues',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
