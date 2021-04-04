<?php

namespace App\Traits\Sttings\IncomeCategory;

use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Collection;

trait IncomeCategoriesServices
{
    
    /**
     * Get latest records of income categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllIncomeCategories (): Collection
    {
        return IncomeCategory::latest()
            ->get([
                'id', 
                ...(new IncomeCategory())->getFillable()
            ]);
    }
    
    /**
     * Get a record of income category via id
     *
     * @param  int $id
     * @return IncomeCategory|null
     */
    public function getIncomeCategoryById (int $id): IncomeCategory|null
    {
        return IncomeCategory::select(
            'id',
            ...(new IncomeCategory())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record of income category
     *
     * @param  string $name
     * @param  string $hexCode
     * @return IncomeCategory
     */
    public function createIncomeCategory (string $name, string $hexCode): IncomeCategory
    {
        return IncomeCategory::create([
            'name' => $name,
            'hex_code' => $hexCode
        ]);
    }
        
    /**
     * Update an existing record of income category
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $hexCode
     * @return boolean
     */
    public function updateIncomeCategory (int $id, string $name, string $hexCode): bool
    {
        $update = IncomeCategory::where('id', $id)
            ->update([
                'name' => $name,
                'hex_code' => $hexCode
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of income categories
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteIncomeCategories (array $ids): bool
    {
        return IncomeCategory::whereIn('id', $ids)->delete();
    }
}