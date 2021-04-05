<?php

namespace App\Traits\Settings\Currency;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

trait CurrenciesServices
{
    
    /**
     * Get latest records of currencies
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCurrencies (): Collection
    {
        return Currency::latest()->get([
            'id',
            ...(new Currency())->getFillable()
        ]);
    }
    
    /**
     * Get a record of currency via id
     *
     * @param  int $id
     * @return Currency|null
     */
    public function getCurrencyById (int $id): Currency|null
    {
        return Currency::select(
            'id',
            ...(new Currency())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record of currency
     *
     * @param  string $name
     * @param  string $code
     * @param  bool $enabled
     * @return Currency
     */
    public function createCurrency (string $name, string $code, bool $enabled): Currency
    {
        return Currency::create([
            'name' => $name,
            'code' => $code,
            'enabled' => $enabled
        ]);
    }
        
    /**
     * Update a new record of currency
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $code
     * @param  bool $enabled
     * @return bool
     */
    public function updateCurrency (int $id, string $name, string $code, bool $enabled): bool
    {
        $update = Currency::where('id', $id)
            ->update([
                'name' => $name,
                'code' => $code,
                'enabled' => $enabled
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of currencies
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteCurrencies (array $ids): bool
    {
        return Currency::whereIn('id', $ids)->delete();
    }
}