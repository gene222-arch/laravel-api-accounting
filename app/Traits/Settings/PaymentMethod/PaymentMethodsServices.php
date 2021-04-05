<?php

namespace App\Traits\Settings\PaymentMethod;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

trait PaymentMethodsServices
{
    
    /**
     * Get latest records of payment methods
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPaymentMethods (): Collection
    {
        return PaymentMethod::latest()
            ->get([
                'id',
                ...(new PaymentMethod())->getFillable()
            ]);
    }
    
    /**
     * Get a record of payment method via id
     *
     * @param  int $id
     * @return PaymentMethod|null
     */
    public function getPaymentMethodById (int $id): PaymentMethod|null
    {
        return PaymentMethod::select(
            'id',
            ...(new PaymentMethod())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record of payment method
     *
     * @param  string $name
     * @param  bool $enabled
     * @return PaymentMethod
     */
    public function createPaymentMethod (string $name, bool $enabled): PaymentMethod
    {
        return PaymentMethod::create([
            'name' => $name,
            'enabled' => $enabled,
        ]);
    }
        
    /**
     * Update an existing record of payment method
     *
     * @param  integer $id
     * @param  string $name
     * @param  bool $enabled
     * @return boolean
     */
    public function updatePaymentMethod (int $id, string $name, bool $enabled): bool
    {
        $update = PaymentMethod::where('id', $id)
            ->update([
                'name' => $name,
                'enabled' => $enabled,
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of payment methods
     *
     * @param  array $ids
     * @return boolean
     */
    public function deletePaymentMethods (array $ids): bool
    {
        return PaymentMethod::whereIn('id', $ids)->delete();
    }
}