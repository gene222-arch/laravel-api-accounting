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
            'name' => 'Bank',
            'number' => 12345,
            'currency' => 'Philippine Peso',
            'openingBalance' => 1000000.00
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
        $data = [
            'id' => 1,
            'name' => 'Bank',
            'number' => 12345,
            'currency' => 'Philippine Peso',
            'openingBalance' => 1000000.00
        ];
        $response = $this->put(
            '/api/banking/accounts',
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
                1
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
