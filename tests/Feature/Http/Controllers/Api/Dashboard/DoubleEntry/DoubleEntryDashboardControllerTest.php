<?php

namespace Tests\Feature\Http\Controllers\Api\Dashboard\DoubleEntry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DoubleEntryDashboardControllerTest extends TestCase
{

    /** @test */
    public function user_can_view_double_entry_dashboard()
    {
        $response = $this->get(
            '/api/dashboards/double-entry?dateFrom=2021-04-25&dateTo=2021-04-25',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));

        $this->assertResponse($response);
    }

}
