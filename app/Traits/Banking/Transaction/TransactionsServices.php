<?php

namespace App\Traits\Banking\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

trait TransactionsServices
{
    
    /**
     * Get latest records of transactions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTransactions (): Collection
    {
        return Transaction::with([
            'account',
            'category'
        ])
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of transaction via id
     *
     * @param  int $id
     * @return Transaction|null
     */
    public function getTransactionById (int $id): Transaction|null
    {
        $transaction = Transaction::find($id);

        return !$transaction
            ? null 
            : $transaction->with([
                    'account',
                    'category'
                ])
                    ->latest()
                    ->get();
    }
    
    /**
     * Create a new record of transaction
     *
     * @param  integer $paymentTransactionId
     * @param  integer $accountId
     * @param  integer $categoryId
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return Transaction
     */
    public function createTransaction (int $paymentTransactionId, int $accountId, int $categoryId, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): Transaction
    {
        return Transaction::create([
            'payment_transaction_id' => $paymentTransactionId,
            'account_id' => $accountId,
            'category_id' => $categoryId,
            'type' => $type,
            'amount' => $amount,
            'deposit' => $deposit,
            'withdrawal' => $withdrawal,
            'description' => $description,
            'contact' => $contact,
        ]);
    }
    
    /**
     * Update an existing record of transaction
     *
     * @param  integer $id 
     * @param  integer $paymentTransactionId
     * @param  integer $accountId
     * @param  integer $categoryId
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return boolean
     */
    public function updateTransaction (int $id, int $paymentTransactionId, int $accountId, int $categoryId, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): bool
    {
        return Transaction::find($id)
            ->update([
                'payment_transaction_id' => $paymentTransactionId,
                'account_id' => $accountId,
                'category_id' => $categoryId,
                'type' => $type,
                'amount' => $amount,
                'deposit' => $deposit,
                'withdrawal' => $withdrawal,
                'description' => $description,
                'contact' => $contact,
            ]);
    }

    /**
     * Delete one or multiple records of transactions
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteTransactions (array $ids): bool
    {
        return Transaction::whereIn('id', $ids)->delete();
    }
}