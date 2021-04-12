<?php

namespace App\Traits\Banking\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

trait HasTransaction
{
    
    /**
     * Create a new record of transaction
     *
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string|null $number
     * @param  integer $account_id
     * @param  integer|null $income_category_id
     * @param  integer|null $expense_category_id
     * @param  integer $payment_method_id
     * @param  string $category
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return Transaction
     */
    public function createTransaction (string $model_type, int $model_id, ?string $number, int $account_id, ?int $income_category_id, ?int $expense_category_id, int $payment_method_id, string $category, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): Transaction
    {
        return Transaction::create([
            'model_type' => $model_type,
            'model_id' => $model_id,
            'number' => $number,
            'account_id' => $account_id,
            'income_category_id' => $income_category_id,
            'expense_category_id' => $expense_category_id,
            'payment_method_id' => $payment_method_id,
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
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string|null $number
     * @param  integer $account_id
     * @param  integer|null $income_category_id
     * @param  integer|null $expense_category_id
     * @param  integer $payment_method_id
     * @param  string $category
     * @param  string $type
     * @param  float $amount
     * @param  float $deposit
     * @param  float $withdrawal
     * @param  string $description
     * @param  string $contact
     * @return boolean
     */
    public function updateTransaction (string $model_type, int $model_id, ?string $number, int $account_id, ?int $income_category_id, ?int $expense_category_id, int $payment_method_id, string $category, string $type, float $amount, float $deposit, float $withdrawal, ?string $description, ?string $contact): bool
    {
        return Transaction::where('model_type', $model_type)
            ->where('model_id', $model_id)
            ->update([
                'model_type' => $model_type,
                'model_id' => $model_id,
                'account_id' => $account_id,
                'number' => $number,
                'income_category_id' => $income_category_id,
                'expense_category_id' => $expense_category_id,
                'payment_method_id' => $payment_method_id,
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