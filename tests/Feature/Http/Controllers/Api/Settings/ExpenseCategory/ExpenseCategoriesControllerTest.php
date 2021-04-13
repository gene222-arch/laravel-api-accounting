<?php

namespace Tests\Feature\Http\Controllers\Api\Settings\ExpenseCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseCategoriesControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_expense_categories()
    {
        $response = $this->get(
            '/api/settings/expense-categories',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_expense_category()
    {
        $id = 12;

        $response = $this->get(
            "/api/settings/expense-categories/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_expense_category()
    {
        $data = [
            'name' => 'Transfer',
            'hex_code' => '#000000'
        ];

        $response = $this->post(
            '/api/settings/expense-categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_expense_category()
    {
        $id = 1;

        $data = [
            'id' => 1,
            'name' => 'Purchase',
            'hex_code' => '#000001'
        ];

        $response = $this->put(
            "/api/settings/expense-categories/${id}",
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_expense_categories()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/settings/expense-categories',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
