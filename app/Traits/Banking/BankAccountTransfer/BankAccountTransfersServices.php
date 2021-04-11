<?php

namespace App\Traits\Banking\BankAccountTransfer;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\BankAccountTransfer;
use Illuminate\Database\Eloquent\Collection;

trait BankAccountTransfersServices
{
    
    /**
     * Get latest records of bank account transfers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBankAccountTransfers (): Collection
    {
        return BankAccountTransfer::with([
            'sender',
            'receiver',
            'paymentMethod'
        ])
            ->latest()
            ->get();
    }
      
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
     * Update an existing record of bank account transfer
     *
     * @param  BankAccountTransfer $transfer
     * @param  array $transfer
     * @param  integer $from_account_id
     * @param  integer $to_account_id
     * @param  float $amount
     * @return mixed
     */
    public function updateBankAccountTransfer (BankAccountTransfer $transfer, array $transfer_details, int $from_account_id, int $to_account_id, float $amount): mixed
    {
        try {
            DB::transaction(function () use ($transfer, $transfer_details, $from_account_id, $to_account_id, $amount)
            {
                $transfer->update($transfer_details);

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