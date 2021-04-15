<?php

namespace Tests\Feature\Http\Controllers\Api\Reports\Accounting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfitAndLossControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_()
    {
        $response = $this->get(
            '/api/reports/accounting/profit-and-loss',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
