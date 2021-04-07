<?php

namespace App\Traits\Purchases\Purchase;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Collection;

trait PurchasesServices
{
    
    /**
     * Get latest records of purchases
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPurchases (): Collection
    {
        return Purchase::latest()
            ->get([
                'id', 
                ...(new Purchase())->getFillable()
            ]);
    }
    
    /**
     * Get a record of purchase via id
     *
     * @param  int $id
     * @return Purchase|null
     */
    public function getPurchaseById (int $id): Purchase|null
    {
        return Purchase::select(
            'id',
            ...(new Purchase())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    
    /**
     * Create a new record of purchase
     *
     * @param  string|null $number
     * @param  integer $accountId
     * @param  integer $vendorId
     * @param  integer $expenseCategoryId
     * @param  integer $paymentMethodId
     * @param  integer $currencyId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return Purchase
     */
    public function createPurchase (?string $number, int $accountId, int $vendorId, int $expenseCategoryId, int $paymentMethodId, int $currencyId, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file): Purchase
    {
        return Purchase::create([
            'number' => $number,
            'account_id' => $accountId,
            'vendor_id' => $vendorId,
            'expense_category_id' => $expenseCategoryId,
            'payment_method_id' => $paymentMethodId,
            'currency_id' => $currencyId,
            'date' => $date,
            'amount' => $amount,
            'description' => $description,
            'recurring' => $recurring,
            'reference' => $reference,
            'file' => $file,
        ]);
    }
        
    /**
     * Update an existing record of purchase
     *
     * @param  string|null $number
     * @param  integer $accountId
     * @param  integer $vendorId
     * @param  integer $expenseCategoryId
     * @param  integer $paymentMethodId
     * @param  integer $currencyId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string $recurring
     * @param  string|null $reference
     * @param  string|null $file
     * @return bool
     */
    public function updatePurchase (int $id, ?string $number, int $accountId, int $vendorId, int $expenseCategoryId, int $paymentMethodId, int $currencyId, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file): bool
    {
        return Purchase::where('id', $id)
            ->update([
                'number' => $number,
                'account_id' => $accountId,
                'vendor_id' => $vendorId,
                'expense_category_id' => $expenseCategoryId,
                'payment_method_id' => $paymentMethodId,
                'currency_id' => $currencyId,
                'date' => $date,
                'amount' => $amount,
                'description' => $description,
                'recurring' => $recurring,
                'reference' => $reference,
                'file' => $file,
            ]);
    }

    /**
     * Delete one or multiple records of purchases
     *
     * @param  array $ids
     * @return boolean
     */
    public function deletePurchases (array $ids): bool
    {
        return Purchase::whereIn('id', $ids)->delete();
    }
}