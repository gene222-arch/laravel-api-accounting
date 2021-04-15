<?php

namespace Tests\Feature\Http\Controllers\Api\Reports;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeSummaryControllerTest extends TestCase
{

    /** @test */
    public function user_can_view_income_summary()
    {
        $response = $this->get(
            '/api/reports/income-summary',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

}
