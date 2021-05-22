<?php

namespace Tests\Feature\Http\Controllers\Api\Dashboard\Main;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainDashboardControllerTest extends TestCase
{

    /** @test */
    public function user_can_view_main_dashboard()
    {
        $response = $this->get(
            '/api/dashboards/main',
            $this->apiHeader()
        );

        dd(json_decode($response->getContent()));
        
        $this->assertResponse($response);
    }

}
