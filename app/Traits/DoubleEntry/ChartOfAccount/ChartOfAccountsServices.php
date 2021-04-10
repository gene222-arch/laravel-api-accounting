<?php

namespace App\Traits\DoubleEntry\ChartOfAccount;

use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Collection;

trait ChartOfAccountsServices
{
    
    /**
     * Get latest records of chart of accounts
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllChartOfAccounts (): Collection
    {
        return ChartOfAccount::latest()
            ->get([
                'id', 
                ...(new ChartOfAccount())->getFillable()
            ]);
    }
    
    /**
     * Get a record of chart of account via id
     *
     * @param  int $id
     * @return ChartOfAccount|null
     */
    public function getChartOfAccountById (int $id): ChartOfAccount|null
    {
        return ChartOfAccount::select(
            'id',
            ...(new ChartOfAccount())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    
    /**
     * Create a new record of chart of account
     *
     * @param  string $name
     * @param  string $code
     * @param  string $type
     * @param  string|null $description
     * @param  bool $enabled
     * @return ChartOfAccount
     */
    public function createChartOfAccount (string $name, string $code, string $type, ?string $description, bool $enabled): ChartOfAccount
    {
        return ChartOfAccount::create([
            'name' => $name,
            'code' => $code,
            'type' => $type,
            'description' => $description,
            'enabled' => $enabled
        ]);
    }

    /**
     * Update an existing record of chart of account
     *
     * @param  string $name
     * @param  string $code
     * @param  string $type
     * @param  string|null $description
     * @param  bool $enabled
     * @return ChartOfAccount
     */
    public function updateChartOfAccount (int $id, string $name, string $code, string $type, ?string $description, bool $enabled): bool
    {
        return ChartOfAccount::where('id', $id)
            ->update([
                'name' => $name,
                'code' => $code,
                'type' => $type,
                'description' => $description,
                'enabled' => $enabled
            ]);
    }

    /**
     * Delete one or multiple records of chart of accounts
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteChartOfAccounts (array $ids): bool
    {
        return ChartOfAccount::whereIn('id', $ids)->delete();
    }
}