<?php

namespace Tests\Feature\Http\Controllers\Api\Reports\Accounting;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaxSummaryControllerTest extends TestCase
{

    /** test */
    public function user_can_view_tax_summary()
    {
        $response = $this->get(
            '/api/reports/accounting/tax-summary',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
