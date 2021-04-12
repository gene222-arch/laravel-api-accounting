<?php

namespace Tests\Feature\Http\Controllers\Api\DoubleEntry\ChartOfAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChartOfAccountsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_chart_of_accounts()
    {
        $response = $this->get(
            '/api/double-entry/chart-of-accounts',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_chart_of_account()
    {
        $id = 1;

        $response = $this->get(
            "/api/double-entry/chart-of-accounts/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_chart_of_account()
    {
        $data = [
            'name' => 'Accounts Payable',
            'code' => '0003',
            'type' => 'Current Payable',
            'enabled' => true
        ];

        $response = $this->post(
            '/api/double-entry/chart-of-accounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_chart_of_account()
    {
        $id = 2;
        
        $data = [
            'id' => 2,
            'name' => 'Accounts Payable',
            'code' => '0001',
            'type' => 'Current Payable',
            'enabled' => true
        ];

        $response = $this->put(
            "/api/double-entry/chart-of-accounts/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_chart_of_accounts()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/double-entry/chart-of-accounts',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
