<?php

namespace Tests\Feature\Http\ControllersApi\Purchases\Purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchasesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_purchases()
    {
        $response = $this->get(
            '/api/purchases/purchases',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_purchase()
    {
        $id = 1;

        $response = $this->get(
            "/api/purchases/purchases/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_purchase()
    {
        $data = [
            'accountId' => 2,
            'vendorId' => 1,
            'expenseCategoryId' => 1,
            'paymentMethodId' => 1,
            'currencyId' => 1,
            'date' => '2021-04-04',
            'amount' => 200.00,
            'recurring' => 'No',
        ];

        $response = $this->post(
            '/api/purchases/purchases',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_purchase()
    {
        $data = [
            'id' => 1,
            'number' => 'BILL-00002',
            'accountId' => 2,
            'vendorId' => 1,
            'expenseCategoryId' => 1,
            'paymentMethodId' => 1,
            'currencyId' => 1,
            'date' => '2021-04-04',
            'amount' => 120.00,
            'recurring' => 'No',
        ];

        $response = $this->put(
            '/api/purchases/purchases',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_purchases()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/purchases/purchases',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
