<?php

namespace App\Traits\Banking\BankAccountTransfer;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccountTransfer;
use Illuminate\Database\Eloquent\Collection;

trait BankAccountTransfersServices
{
      
    /**
     * Create a new record of bank account transfer
     *
     * @param  array $transfer_details
     * @param  integer $from_account_id
     * @param  integer $to_account_id
     * @param  float $amount
     * @return mixed
     */
    public function createBankAccountTransfer (array $transfer_details, int $from_account_id, int $to_account_id, float $amount): mixed
    {
        try {
            DB::transaction(function () use ($transfer_details, $from_account_id, $to_account_id, $amount)
            {
                BankAccountTransfer::create($transfer_details);

                Account::where('id', $from_account_id)
                    ->update(['balance' => DB::raw("balance - ${amount}")]);

                Account::where('id', $to_account_id)
                    ->update(['balance' => DB::raw("balance + ${amount}")]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Reverse previous transaction
     *
     * @param  BankAccountTransfer $transfer
     * @return mixed
     */
    public function reverseTransaction (BankAccountTransfer $transfer): mixed
    {
        try {
            DB::transaction(function () use ($transfer)
            {   
                Account::where('id', $transfer->from_account_id)
                    ->update(['balance' => DB::raw("balance + {$transfer->amount}")]);

                Account::where('id', $transfer->to_account_id)
                    ->update(['balance' => DB::raw("balance - {$transfer->amount}")]);

                $transfer->delete();
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of bank account transfers
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteBankAccountTransfers (array $ids): bool
    {
        return BankAccountTransfer::whereIn('id', $ids)->delete();
    }
}