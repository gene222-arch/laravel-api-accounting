<?php

namespace App\Traits\Banking\BankAccountReconciliation;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccountReconciliation;
use Illuminate\Database\Eloquent\Collection;

trait BankAccountReconciliationsServices
{
    
    /**
     * Get latest records of bank account reconciliations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBankAccountReconciliations (): Collection
    {
        return BankAccountReconciliation::with('account')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of bank account reconciliation via id
     *
     * @param  int $id
     * @return BankAccountReconciliation|null
     */
    public function getBankAccountReconciliationById (int $id): BankAccountReconciliation|null
    {
        $reconciliation = BankAccountReconciliation::find($id);

        return !$reconciliation
            ? null 
            : $reconciliation->with('account')->first();
    }
    
    /**
     * Create a new record of bank account reconciliation
     *
     * @param  integer $accountId
     * @param  string $startedAt
     * @param  string $endedAt
     * @param  float $closingBalance
     * @param  float $clearedAmount
     * @param  float $difference
     * @param  bool $reconciled
     * @return mixed
     */
    public function createBankAccountReconciliation (int $accountId, string $startedAt, string $endedAt, float $closingBalance, float $clearedAmount, float $difference, bool $reconciled): mixed
    {
        try {
            DB::transaction(function () use ($accountId, $startedAt, $endedAt, $closingBalance, $clearedAmount, $difference, $reconciled)
            {
                BankAccountReconciliation::create([
                    'account_id' => $accountId,
                    'started_at' => $startedAt,
                    'ended_at' => $endedAt,
                    'closing_balance' => $closingBalance,
                    'cleared_amount' => $clearedAmount,
                    'difference' => $difference,
                    'status' => $reconciled ? 'Reconciled' : 'Uneconciled'
                ]);

                Account::find($accountId)->update([
                    'balance' => DB::raw("balance - ${closingBalance}")
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of bank account reconciliation
     *
     * @param  integer $id
     * @param  integer $accountId
     * @param  string $startedAt
     * @param  string $endedAt
     * @param  float $closingBalance
     * @param  float $clearedAmount
     * @param  float $difference
     * @param  bool $reconciled
     * @return mixed
     */
    public function updateBankAccountReconciliation (int $id, int $accountId, string $startedAt, string $endedAt, float $closingBalance, float $clearedAmount, float $difference, bool $reconciled): mixed
    {
        try {
            DB::transaction(function () use ($id, $accountId, $startedAt, $endedAt, $closingBalance, $clearedAmount, $difference, $reconciled)
            {
                BankAccountReconciliation::find($id)
                ->update([
                    'account_id' => $accountId,
                    'started_at' => $startedAt,
                    'ended_at' => $endedAt,
                    'closing_balance' => $closingBalance,
                    'cleared_amount' => $clearedAmount,
                    'difference' => $difference,
                    'status' => $reconciled ? 'Reconciled' : 'Uneconciled'
                ]);

                Account::find($accountId)->update([
                    'balance' => DB::raw("balance - ${closingBalance}")
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of BankAccountReconciliations
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteBankAccountReconciliations (array $ids): bool
    {
        return BankAccountReconciliation::whereIn('id', $ids)->delete();
    }
}