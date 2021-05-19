<?php

namespace Tests\Feature\Http\Controllers\Api\Reports;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportsDashboardControllerTest extends TestCase
{

    /** test */
    public function user_can_view_reports_dashboard()
    {
        $response = $this->get(
            '/api/reports',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }
}
