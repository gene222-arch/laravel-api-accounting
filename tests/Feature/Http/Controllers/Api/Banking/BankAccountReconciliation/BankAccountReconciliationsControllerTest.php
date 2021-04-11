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
            'account_id' => 1,
            'started_at' => '2020-01-01',
            'ended_at' => '2020-02-03',
            'closing_balance' => 100.00,
            'cleared_amount' => 100.00,
            'difference' => 0,
            'status' => 'Reconciled',
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
        $reconciliationId = 1;

        $accountId = 1;

        $data = [
            'started_at' => '2020-01-01',
            'ended_at' => '2020-02-03',
            'closing_balance' => 100.00,
            'cleared_amount' => 100.00,
            'difference' => 10,
            'status' => 'Unreconciled',
        ];

        $response = $this->put(
            "/api/banking/reconciliations/${reconciliationId}/accounts/${accountId}",
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
