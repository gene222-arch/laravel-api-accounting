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
     * Get a record of bank account transfer via id
     *
     * @param  int $id
     * @return BankAccountTransfer|null
     */
    public function getBankAccountTransferById (int $id): BankAccountTransfer|null
    {
        $transfer = BankAccountTransfer::find($id);

        return !$transfer
            ? null 
            : $transfer->with([
                'sender',
                'receiver',
                'paymentMethod'
            ])
            ->first();
    }
    
    
    /**
     * Create a new record of bank account transfer
     *
     * @param  integer $fromAccountId
     * @param  integer $toAccountId
     * @param  integer $paymentMethodId
     * @param  float $amount
     * @param  string $transferredAt
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function createBankAccountTransfer (int $fromAccountId, int $toAccountId, int $paymentMethodId, float $amount, string $transferredAt, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($fromAccountId, $toAccountId, $paymentMethodId, $amount, $transferredAt, $description, $reference)
            {
                BankAccountTransfer::create([
                    'from_account_id' => $fromAccountId,
                    'to_account_id' => $toAccountId,
                    'payment_method_id' => $paymentMethodId,
                    'amount' => $amount,
                    'transferred_at' => $transferredAt,
                    'description' => $description,
                    'reference' => $reference
                ]);

                Account::find($fromAccountId)
                    ->update([
                        'balance' => DB::raw("balance - ${amount}")
                    ]);

                Account::find($toAccountId)
                    ->update([
                        'balance' => DB::raw("balance + ${amount}")
                    ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of bank account transfer
     *
     * @param  integer $id
     * @param  integer $fromAccountId
     * @param  integer $toAccountId
     * @param  integer $paymentMethodId
     * @param  float $amount
     * @param  string $transferredAt
     * @param  string|null $description
     * @param  string|null $reference
     * @return mixed
     */
    public function updateBankAccountTransfer (int $id, int $fromAccountId, int $toAccountId, int $paymentMethodId, float $amount, string $transferredAt, ?string $description, ?string $reference): mixed
    {
        try {
            DB::transaction(function () use ($id, $fromAccountId, $toAccountId, $paymentMethodId, $amount, $transferredAt, $description, $reference)
            {
                BankAccountTransfer::where('id', $id)
                    ->update([
                        'from_account_id' => $fromAccountId,
                        'to_account_id' => $toAccountId,
                        'payment_method_id' => $paymentMethodId,
                        'amount' => $amount,
                        'transferred_at' => $transferredAt,
                        'description' => $description,
                        'reference' => $reference
                    ]);

                Account::find($fromAccountId)
                    ->update([
                        'balance' => DB::raw("balance - ${amount}")
                    ]);

                Account::find($toAccountId)
                    ->update([
                        'balance' => DB::raw("balance + ${amount}")
                    ]);
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