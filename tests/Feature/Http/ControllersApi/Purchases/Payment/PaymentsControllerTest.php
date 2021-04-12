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
        $id = 2;

        $response = $this->get(
            "/api/purchases/payments/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_payment()
    {
        $data = [
            'account_id' => 1,
            'vendor_id' => 1,
            'expense_category_id' => 1,
            'payment_method_id' => 1,
            'currency_id' => 1,
            'date' => '2021-04-04',
            'amount' => 10.00,
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
        $id = 6;

        $data = [
            'id' => 6,
            'account_id' => 1,
            'vendor_id' => 1,
            'expense_category_id' => 1,
            'payment_method_id' => 1,
            'currency_id' => 1,
            'date' => '2021-04-04',
            'amount' => 20.00,
            'recurring' => 'No',
        ];

        $response = $this->put(
            "/api/purchases/payments/${id}",
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
