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
        $id = 2;

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
            'fromAccountId' => 2,
            'toAccountId' => 3,
            'paymentMethodId' => 1,
            'amount' => 100.00,
            'transferredAt' => '2022-05-05',
        ];

        $response = $this->post(
            '/api/banking/transfers',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_bank_account_transfer()
    {
        $data = [
            'id' => 2,
            'fromAccountId' => 2,
            'toAccountId' => 3,
            'paymentMethodId' => 1,
            'amount' => 5.00,
            'transferredAt' => '2022-05-05',
        ];

        $response = $this->put(
            '/api/banking/transfers',
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
