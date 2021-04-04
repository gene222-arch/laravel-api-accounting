<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\IncomeCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeCategoriesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_income_categories()
    {
        $response = $this->get(
            '/api/settings/income-categories',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_income_category()
    {
        $id = 1;

        $response = $this->get(
            "/api/settings/income-categories/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_income_category()
    {
        $data = [
            'name' => 'Deposit',
            'hexCode' => '#000001'
        ];

        $response = $this->post(
            '/api/settings/income-categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_income_category()
    {
        $data = [
            'id' => 2,
            'name' => 'Deposit',
            'hexCode' => '#000002'
        ];

        $response = $this->put(
            '/api/settings/income-categories',
            $data,
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_income_categories()
    {
        $data = [
            'ids' => [
                2
            ]
        ];

        $response = $this->delete(
            '/api/settings/income-categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
