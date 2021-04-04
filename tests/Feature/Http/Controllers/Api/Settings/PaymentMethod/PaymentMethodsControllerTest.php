<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\PaymentMethod;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_payment_methods()
    {
        $response = $this->get(
            '/api/settings/payment-methods',
            $this->apiHeader()
        );


        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_payment_method()
    {
        $id = 1;

        $response = $this->get(
            "/api/settings/payment-methods/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_payment_method()
    {
        $data = [
            'name' => 'Deposit'
        ];

        $response = $this->post(
            '/api/settings/payment-methods',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_payment_method()
    {
        $data = [
            'id' => 1,
            'name' => 'Cash'
        ];

        $response = $this->put(
            '/api/settings/payment-methods',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_payment_methods()
    {
        $data = [
            'ids' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/settings/payment-methods',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
