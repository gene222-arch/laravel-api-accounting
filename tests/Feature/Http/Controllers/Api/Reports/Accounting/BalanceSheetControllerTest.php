<?php

namespace Tests\Feature\Http\Controllers\Api\Reports\Accounting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BalanceSheetControllerTest extends TestCase
{

    /** test */
    public function user_can_view_balance_sheet()
    {
        $response = $this->get(
            '/api/reports/accounting/balance-sheet',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
