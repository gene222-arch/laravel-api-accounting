<?php

namespace App\Traits\Banking\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

trait HasTransaction
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
            'incomeCategory',
            'expenseCategory'
        ])
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of transaction via id
     *
     * @param  int $id
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getTransactionById (int $id): Collection|null
    {
        return Transaction::where('id', $id)
            ->with([
                'account',
                'incomeCategory',
                'expenseCategory'
            ])
            ->latest()
            ->get();
    }

    /**
     * Get a record of transaction via account id
     *
     * @param  int $id
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getTransactionByAccountId (int $id): Collection|null
    {
        return Transaction::where('account_id', $id)
            ->with([
                'account',
                'incomeCategory',
                'expenseCategory'
            ])
            ->latest()
            ->get();
    }
    
    /**
     * Create a new record of transaction
     *
     * @param  string $modelType
     * @param  integer $modelId
     * @param  integer $accountId
     * @param  integer $incomeCategoryId
     * @param  integer $expenseCategoryId
     * @param  string $category
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return Transaction
     */
    public function createTransaction (string $modelType, int $modelId, int $accountId, ?int $incomeCategoryId, ?int $expenseCategoryId, string $category, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): Transaction
    {
        return Transaction::create([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'account_id' => $accountId,
            'income_category_id' => $incomeCategoryId,
            'expense_category_id' => $expenseCategoryId,
            'category' => $category,
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
     * @param  string $modelType
     * @param  integer $modelId
     * @param  integer $accountId
     * @param  integer $incomeCategoryId
     * @param  integer $expenseCategoryId
     * @param  string $category
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return boolean
     */
    public function updateTransaction (int $id, string $modelType, int $modelId, int $accountId, int $incomeCategoryId, int $expenseCategoryId, string $category, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): bool
    {
        return Transaction::find($id)
            ->update([
                'model_type' => $modelType,
                'model_id' => $modelId,
                'account_id' => $accountId,
                'income_category_id' => $incomeCategoryId,
                'expense_category_id' => $expenseCategoryId,
                'category' => $category,
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