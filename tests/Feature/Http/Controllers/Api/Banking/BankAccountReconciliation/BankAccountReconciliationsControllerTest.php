<?php

namespace Tests\Feature\Http\Controllers\Api\Banking\BankAccountReconciliation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankAccountReconciliationsControllerTest extends TestCase
{

    /** test */
    public function user_can_view_any_bank_account_reconciliations()
    {
        $response = $this->get(
            '/api/banking/reconciliations',
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_view_bank_account_reconciliation()
    {
        $id = 1;

        $response = $this->get(
            "/api/banking/reconciliations/${id}",
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_create_bank_account_reconciliation()
    {
        $data = [
            'accountId' => 2,
            'startedAt' => '2020-01-01',
            'endedAt' => '2020-02-03',
            'closingBalance' => 100.00,
            'clearedAmount' => 100.00,
            'difference' => 100.00,
            'reconciled' => false,
        ];

        $response = $this->post(
            '/api/banking/reconciliations',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_update_bank_account_reconciliation()
    {
        $data = [
            'id' => 3,
            'accountId' => 3,
            'startedAt' => '2020-01-01',
            'endedAt' => '2020-02-03',
            'closingBalance' => 110.00,
            'clearedAmount' => -110.00,
            'difference' => 0.00,
            'reconciled' => true,
        ];

        $response = $this->put(
            '/api/banking/reconciliations',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

    /** test */
    public function user_can_delete_bank_account_reconciliations()
    {
        $data = [
            'ids' => [
                1
            ]
        ];

        $response = $this->delete(
            '/api/banking/reconciliations',
            $data,
            $this->apiHeader()
        );

        $this->assertResponse($response);
    }

}
