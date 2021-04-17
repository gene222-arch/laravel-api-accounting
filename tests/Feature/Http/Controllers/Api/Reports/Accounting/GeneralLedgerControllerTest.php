<?php

namespace Tests\Feature\Http\Controllers\Api\Reports\Accounting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneralLedgerControllerTest extends TestCase
{

    /** test */
    public function user_can_view_general_ledger()
    {
        $response = $this->get(
            '/api/reports/accounting/general-ledger',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
