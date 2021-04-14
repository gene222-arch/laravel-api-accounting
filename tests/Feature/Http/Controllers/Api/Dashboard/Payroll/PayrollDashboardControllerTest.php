<?php

namespace Tests\Feature\Http\Controllers\Api\Dashboard\Payroll;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayrollDashboardControllerTest extends TestCase
{

    /** test */
    public function user_can_view_payroll_dashboard()
    {
        $response = $this->get(
            '/api/dashboards/payroll',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
