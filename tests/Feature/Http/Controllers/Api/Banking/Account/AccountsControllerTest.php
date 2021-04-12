<?php

namespace Tests\Feature\Http\Controllers\Api\Banking\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_accounts()
    {
        $response = $this->get(
            '/api/banking/accounts',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_account()
    {
        $id = 1;

        $response = $this->get(
            "/api/banking/accounts/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_account()
    {
        $data = [
            'currency_id' => 1,
            'name' => 'PSS',
            'number' => 12345,
            'opening_balance' => 1000000.00,
            'balance' => 1000000.00,
            'enabled' => true,
        ];

        $response = $this->post(
            '/api/banking/accounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_account()
    {
        $id = 1; 

        $data = [
            'id' => 2,
            'currency_id' => 1,
            'name' => 'Bank account',
            'number' => 2222,
            'opening_balance' => 1000000.00,
            'balance' => 1000000.00,
            'enabled' => true,
        ];

        $response = $this->put(
            "/api/banking/accounts/${id}",
            $data,
            $this->apiHeader()
        );
 
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_accounts()
    {
        $data = [
            'ids' => [
                3
            ]
        ];

        $response = $this->delete(
            '/api/banking/accounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
