<?php

namespace App\Traits\Item\Discount;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Collection;

trait DiscountsServices
{
    
    /**
     * Get all latest records of discounts
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllDiscounts (): Collection
    {
        return Discount::latest()->get([
            'id',
            ...(new Discount())->getFillable()
        ]);
    }
    
    /**
     * Get a record of discount via id
     *
     * @param  integer $id
     * @return Discount|null
     */
    public function getDiscountById (int $id): Discount|null
    {
        return Discount::select(
            'id',
            ...(new Discount())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record of discount
     *
     * @param  string $name
     * @param  float $rate
     * @param  bool $enabled
     * @return Discount
     */
    public function createDiscount (string $name, float $rate, bool $enabled): Discount
    {
        return Discount::create([
            'name' => $name,
            'rate' => $rate,
            'enabled' => $enabled
        ]);
    }
    
    /**
     * Update an existing record of discount
     *
     * @param  integer $id
     * @param  string $name
     * @param  float $rate
     * @param  bool $enabled
     * @return boolean
     */
    public function updateDiscount (int $id, string $name, float $rate, bool $enabled): bool
    {
        $update = Discount::where('id', $id)
            ->update([
                'name' => $name,
                'rate' => $rate,
                'enabled' => $enabled
            ]);
            
        return boolval($update);
    }
    
    /**
     * Delete one or multiple records of discounts
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteDiscounts (array $ids): bool
    {
        return Discount::whereIn('id', $ids)->delete();
    }
}