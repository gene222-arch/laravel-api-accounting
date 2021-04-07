<?php

namespace Tests\Feature\Http\Controllers\Api\Banking\Transaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_transactions()
    {
        $response = $this->get(
            '/api/banking/transactions',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_transaction()
    {
        $id = 1;

        $response = $this->get(
            "/api/banking/transactions/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** @test */
    public function user_can_view_transaction_by_account()
    {
        $id = 2;

        $response = $this->get(
            "/api/banking/transactions/account/${id}",
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }
}
