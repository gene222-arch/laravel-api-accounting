<?php

namespace Tests\Feature\Http\Controllers\Api\Reports;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseSummaryControllerTest extends TestCase
{

    /** test */
    public function user_can_view_expense_summary()
    {
        $response = $this->get(
            '/api/reports/expense-summary',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
