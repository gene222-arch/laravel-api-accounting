<?php

namespace App\Traits\Purchases\Payment;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

trait PaymentsServices
{
    
    /**
     * Get latest records of payments
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayments (): Collection
    {
        return Payment::latest()
            ->get([
                'id', 
                ...(new Payment())->getFillable()
            ]);
    }
    
    /**
     * Get a record of payment via id
     *
     * @param  int $id
     * @return Payment|null
     */
    public function getPaymentById (int $id): Payment|null
    {
        return Payment::select(
            'id',
            ...(new Payment())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    
    /**
     * Create a new record of payment
     *
     * @param  string|null $number
     * @param  integer $account_id
     * @param  integer $vendor_id
     * @param  integer $expense_category_id
     * @param  integer $payment_method_id
     * @param  integer $currency_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return Payment
     */
    public function createPayment (?string $number, int $account_id, int $vendor_id, int $expense_category_id, int $payment_method_id, int $currency_id, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file): Payment
    {
        return Payment::create([
            'number' => $number,
            'account_id' => $account_id,
            'vendor_id' => $vendor_id,
            'expense_category_id' => $expense_category_id,
            'payment_method_id' => $payment_method_id,
            'currency_id' => $currency_id,
            'date' => $date,
            'amount' => $amount,
            'description' => $description,
            'recurring' => $recurring,
            'reference' => $reference,
            'file' => $file,
        ]);
    }
        
    /**
     * Update an existing record of payment
     *
     * @param  string|null $number
     * @param  integer $account_id
     * @param  integer $vendor_id
     * @param  integer $expense_category_id
     * @param  integer $payment_method_id
     * @param  integer $currency_id
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return bool
     */
    public function updatePayment (int $id, ?string $number, int $account_id, int $vendor_id, int $expense_category_id, int $payment_method_id, int $currency_id, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file): bool
    {
        return Payment::where('id', $id)
            ->update([
                'number' => $number,
                'account_id' => $account_id,
                'vendor_id' => $vendor_id,
                'expense_category_id' => $expense_category_id,
                'payment_method_id' => $payment_method_id,
                'currency_id' => $currency_id,
                'date' => $date,
                'amount' => $amount,
                'description' => $description,
                'recurring' => $recurring,
                'reference' => $reference,
                'file' => $file,
            ]);
    }

    /**
     * Delete one or multiple records of Payments
     *
     * @param  array $ids
     * @return boolean
     */
    public function deletePayments (array $ids): bool
    {
        return Payment::whereIn('id', $ids)->delete();
    }
}