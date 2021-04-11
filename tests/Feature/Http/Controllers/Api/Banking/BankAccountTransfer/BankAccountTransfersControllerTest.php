<?php

namespace Tests\Feature\Http\Controllers\Api\Banking\BankAccountTransfer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankAccountTransfersControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_bank_account_transfers()
    {
        $response = $this->get(
            '/api/banking/transfers',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_bank_account_transfer()
    {
        $id = 1;

        $response = $this->get(
            "/api/banking/transfers/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_bank_account_transfer()
    {
        $data = [
            'from_account_id' => 1,
            'to_account_id' => 2,
            'payment_method_id' => 1,
            'amount' => 100.00,
            'transferred_at' => '2022-05-05',
        ];

        $response = $this->post(
            '/api/banking/transfers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_update_bank_account_transfer()
    {
        $id = 1;

        $data = [
            'from_account_id' => 2,
            'to_account_id' => 1,
            'payment_method_id' => 1,
            'amount' => 100.00,
            'transferred_at' => '2022-05-05',
        ];

        $response = $this->put(
            "/api/banking/transfers/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_bank_account_transfers()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/banking/transfers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
