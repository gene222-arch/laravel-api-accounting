<?php

namespace App\Traits\Banking\Account;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

trait AccountsServices
{
    
    /**
     * Get latest records of accounts
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAccounts (): Collection
    {
        return Account::latest()
            ->get([
                'id',
                ...(new Account())->getFillable()
            ]);
    }
    
    /**
     * Get a record of account via id
     *
     * @param  int $id
     * @return Account|null
     */
    public function getAccountById (int $id): Account|null
    {
        return Account::select(
            'id',
            ...(new Account())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    
    /**
     * Create a new record of account
     *
     * @param  string $name
     * @param  integer $number
     * @param  string $currency
     * @param  float $openingBalance
     * @return Account
     */
    public function createAccount (string $name, int $number, string $currency, float $openingBalance): Account
    {
        return Account::create([
            'name' => $name,
            'number' => $number,
            'currency' => $currency,
            'opening_balance' => $openingBalance
        ]);
    }
        
    /**
     * Update an existing record of account
     *
     * @param  integer $id
     * @param  string $name
     * @param  integer $number
     * @param  string $currency
     * @param  float $openingBalance
     * @return boolean
     */
    public function updateAccount (int $id, string $name, int $number, string $currency, float $openingBalance): bool
    {
        $update = Account::where('id', $id)
            ->update([
                'name' => $name,
                'number' => $number,
                'currency' => $currency,
                'opening_balance' => $openingBalance
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of accounts
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteAccounts (array $ids): bool
    {
        return Account::whereIn('id', $ids)->delete();
    }
}