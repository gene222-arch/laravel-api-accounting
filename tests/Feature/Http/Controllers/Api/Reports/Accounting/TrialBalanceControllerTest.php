<?php

namespace Tests\Feature\Http\Controllers\Api\Reports\Accounting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrialBalanceControllerTest extends TestCase
{

    /** test */
    public function user_can_view_trial_balance()
    {
        $response = $this->get(
            '/api/reports/accounting/trial-balance',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
