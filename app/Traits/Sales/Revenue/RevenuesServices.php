<?php

namespace App\Traits\Sales\Revenue;

use App\Models\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait RevenuesServices
{
    
    /**
     * Get latest records of revenues
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRevenues (): Collection
    {
        return Revenue::with([
            'account',
            'customer',
            'incomeCategory',
            'paymentMethod',
            'invoices'
        ])
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of revenue via id
     *
     * @param  int $id
     * @return Revenue|null
     */
    public function getRevenueById (int $id): Revenue|null
    {
        return Revenue::where('id', $id)
            ->with([
                'account',
                'customer',
                'incomeCategory',
                'paymentMethod',
                'invoices'
            ])
            ->first();
    }
    
    
    /**
     * Create a new record of revenue
     *
     * @param string|null $number
     * @param string $date
     * @param float $amount
     * @param string|null $description
     * @param string|null $recurring
     * @param string|null $reference
     * @param string|null $file
     * @param integer $accountId
     * @param integer $customerId
     * @param integer $incomeCategoryId
     * @param integer $paymentMethodId
     * @param integer $currencyId
     * @return mixed
     */
    public function createRevenue (?string $number, string $date, float $amount, ?string $description, ?string $recurring, ?string $reference, ?string $file, int $accountId, int $customerId, int $incomeCategoryId, int $paymentMethodId, int $currencyId): mixed
    {
        try {
            DB::transaction(function () use (
                $number, $date, $amount, $description, $recurring, $reference, $file,
                $accountId, $customerId, $incomeCategoryId, $paymentMethodId, $currencyId
            )
            {
                $revenue = Revenue::create([
                    'number' => $number,
                    'account_id' => $accountId,
                    'customer_id' => $customerId,
                    'income_category_id' => $incomeCategoryId,
                    'payment_method_id' => $paymentMethodId,
                    'currency_id' => $currencyId,
                    'date' =>  $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $recurring,
                    'reference' => $reference,
                    'file' => $file
                ]);

                $revenue->invoices()->attach($currencyId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of revenue
     *
     * @param integer $id
     * @param string|null $number
     * @param string $date
     * @param float $amount
     * @param string|null $description
     * @param string $recurring
     * @param string|null $reference
     * @param string|null $file
     * @param integer $accountId
     * @param integer $customerId
     * @param integer $incomeCategoryId
     * @param integer $paymentMethodId
     * @param integer $currencyId
     * @return mixed
     */
    public function updateRevenue (int $id, string $number, string $date, float $amount, ?string $description, string $recurring, ?string $reference, ?string $file, int $accountId, int $customerId, int $incomeCategoryId, int $paymentMethodId, int $currencyId): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $number, $date, $amount, $description, $recurring, $reference, $file,
                $accountId, $customerId, $incomeCategoryId, $paymentMethodId, $currencyId
            )
            {
                $revenue = Revenue::find($id);

                $revenue->update([
                    'number' => $number,
                    'account_id' => $accountId,
                    'customer_id' => $customerId,
                    'income_category_id' => $incomeCategoryId,
                    'payment_method_id' => $paymentMethodId,
                    'currency_id' => $currencyId,
                    'date' =>  $date,
                    'amount' => $amount,
                    'description' => $description,
                    'recurring' => $recurring,
                    'reference' => $reference,
                    'file' => $file
                ]);

                $revenue->invoices()->sync($currencyId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of revenues
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteRevenues (array $ids): bool
    {
        return Revenue::whereIn('id', $ids)->delete();
    }
}