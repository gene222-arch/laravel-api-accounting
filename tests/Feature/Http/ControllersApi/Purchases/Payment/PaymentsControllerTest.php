<?php

namespace Tests\Feature\Http\ControllersApi\Purchases\Payment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_payments()
    {
        $response = $this->get(
            '/api/purchases/payments',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_payment()
    {
        $id = 1;

        $response = $this->get(
            "/api/purchases/payments/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_payment()
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
            '/api/purchases/payments',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_payment()
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
            '/api/purchases/payments',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_payments()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/purchases/payments',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
