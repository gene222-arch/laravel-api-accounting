<?php

namespace Tests\Feature\Http\Controllers\Api\Reports;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeVsExpenseControllerTest extends TestCase
{

    /** test */
    public function user_can_view_income_vs_expense_summary()
    {
        $response = $this->get(
            '/api/reports/income-vs-expense',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }
}
