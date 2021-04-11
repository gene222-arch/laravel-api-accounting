<?php

namespace App\Traits\Banking\BankAccountReconciliation;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccountReconciliation;
use Illuminate\Database\Eloquent\Collection;

trait BankAccountReconciliationsServices
{
    
    /**
     * Create a new record of bank account reconciliation
     *
     * @param  array $reconciliationDetails
     * @param  Account $account
     * @param  float $closing_balance
     * @param  float $closing_balance
     * @param  string $status
     * @return mixed
     */
    public function createBankAccountReconciliation (array $reconciliationDetails, Account $account, float $closing_balance, float $difference, string $status): mixed
    {
        try {
            DB::transaction(function () use ($reconciliationDetails, $account, $closing_balance, $difference, $status)
            {
                $status = $this->setStatus($status, $difference);
                
                BankAccountReconciliation::create($reconciliationDetails);

                $status === 'Reconciled' && (
                    $account->update([
                        'balance' => DB::raw("balance - ${closing_balance}")
                    ]));
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of bank account reconciliation
     *
     * @param  BankAccountReconciliation $reconciliation
     * @param  array $reconciliationDetails
     * @param  Account $account
     * @param  float $closing_balance
     * @param  float $closing_balance
     * @param  string $status
     * @return mixed
     */
    public function updateBankAccountReconciliation (BankAccountReconciliation $reconciliation, array $reconciliationDetails, Account $account, float $closing_balance, float $difference, string $status): mixed
    {
        try {
            DB::transaction(function () use ($reconciliation ,$reconciliationDetails, $account, $closing_balance, $difference, $status)
            {
                $status = $this->setStatus($status, $difference);

                $reconciliation->update($reconciliationDetails);

                $status === 'Reconciled' && (
                    $account->update([
                        'balance' => DB::raw("balance - ${closing_balance}")
                    ]));
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Set the status of reconciliations
     *
     * @param  string $status
     * @param  float $difference
     * @return string
     */
    public function setStatus (string $status, float $difference): string
    {
        return !($status === 'Reconciled' && empty($difference)) ? 'Unrenconciled' : $status;
    }
}