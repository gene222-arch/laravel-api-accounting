<?php

namespace App\Traits\Item;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Collection;

trait TaxServices
{
        
    /**
     * Get all records of taxes 
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTaxes (): Collection
    {
        return Tax::all(['id', 'name', 'rate', 'type', 'enabled']);
    }
        
    /**
     * Get a record of tax via id
     *
     * @param  int $id
     * @return \App\Models\Tax|null
     */
    public function getTaxById (int $id): Tax|null
    {
        return Tax::select('id', 'name', 'rate', 'type', 'enabled')->where('id', $id)->first();
    }

    /**
     * Create a new record of tax
     *
     * @param  string $name
     * @param  float $rate
     * @param  string $type
     * @return \App\Models\Tax
     */
    public function createTax (string $name, float $rate, string $type, bool $enabled): Tax
    {
        return Tax::create([
            'name' => $name,
            'rate' => $rate,
            'type' => $type,
            'enabled' => $enabled,
            'updated_at' => null
        ]);
    }
        
    /**
     * Update an existing record of tax
     *
     * @param  integer $id
     * @param  string $name
     * @param  float $rate
     * @param  string $type
     * @return bool
     */
    public function updateTax (int $id, string $name, float $rate, string $type, bool $enabled): bool
    {
        $update = Tax::where('id', $id)
            ->update([
                'name' => $name,
                'rate' => $rate,
                'type' => $type,
                'enabled' => $enabled,
                'updated_at' => now()
            ]);

        return boolval($update);
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