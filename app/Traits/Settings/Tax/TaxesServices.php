<?php

namespace App\Traits\Settings\Tax;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Collection;

trait TaxesServices
{
        
    /**
     * Get all latest records of taxes 
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTaxes (): Collection
    {
        return Tax::latest()->get([
            'id', 
            ...(new Tax())->getFillable()
        ]);
    }
        
    /**
     * Get a record of tax via id
     *
     * @param  int $id
     * @return \App\Models\Tax|null
     */
    public function getTaxById (int $id): Tax|null
    {
        return Tax::select(
            'id', 
            ...(new Tax())->getFillable()
        )
            ->where('id', $id)->first();
    }

    /**
     * Create a new record of tax
     *
     * @param  string $name
     * @param  float $rate
     * @param  string $type
     * @param  bool $enabled
     * @return \App\Models\Tax
     */
    public function createTax (string $name, float $rate, string $type, bool $enabled): Tax
    {
        return Tax::create([
            'name' => $name,
            'rate' => $rate,
            'type' => $type,
            'enabled' => $enabled
        ]);
    }
        
    /**
     * Update an existing record of tax
     *
     * @param  integer $id
     * @param  string $name
     * @param  float $rate
     * @param  string $type
     * @return boolean
     */
    public function updateTax (int $id, string $name, float $rate, string $type, bool $enabled): bool
    {
        return Tax::where('id', $id)
            ->update([
                'name' => $name,
                'rate' => $rate,
                'type' => $type,
                'enabled' => $enabled
            ]);
    }
        
    /**
     * Delete one or multiple existing records of taxes
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteTaxes (array $ids): bool
    {
        return Tax::whereIn('id', $ids)->delete();
    }

}