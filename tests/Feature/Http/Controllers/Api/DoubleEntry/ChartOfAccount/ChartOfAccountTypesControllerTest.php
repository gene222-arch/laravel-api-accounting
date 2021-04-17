<?php

namespace Tests\Feature\Http\Controllers\Api\DoubleEntry\ChartOfAccount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChartOfAccountTypesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_chart_of_account_types()
    {
        $response = $this->get(
            '/api/double-entry/chart-of-account-types',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_chart_of_account_type()
    {
        $id = 1;

        $response = $this->get(
            "/api/double-entry/chart-of-account-types/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_chart_of_account_type()
    {
        $data = [
            'category' => 'Liability',
            'name' => 'Current Payable',
            'description' => ''
        ];

        $response = $this->post(
            '/api/double-entry/chart-of-account-types',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_chart_of_account_type()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'category' => 'Asset',
            'name' => 'Fixed Asset',
            'description' => ''
        ];

        $response = $this->put(
            "/api/double-entry/chart-of-account-types/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_chart_of_account_types()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/double-entry/chart-of-account-types',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
