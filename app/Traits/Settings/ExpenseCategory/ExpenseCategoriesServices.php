<?php

namespace App\Traits\Settings\ExpenseCategory;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Collection;

trait ExpenseCategoriesServices
{
    
    /**
     * Get latest records of expense categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllExpenseCategories (): Collection
    {
        return ExpenseCategory::latest()
            ->get([
                'id', 
                ...(new ExpenseCategory())->getFillable()
            ]);
    }
    
    /**
     * Get a record of expensec category via id
     *
     * @param  int $id
     * @return ExpenseCategory|null
     */
    public function getExpenseCategoryById (int $id): ExpenseCategory|null
    {
        return ExpenseCategory::select(
            'id',
            ...(new ExpenseCategory())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of expense category
     *
     * @param  string $name
     * @param  string $hexCode
     * @return ExpenseCategory
     */
    public function createExpenseCategory (string $name, string $hexCode): ExpenseCategory
    {
        return ExpenseCategory::create([
            'name' => $name,
            'hex_code' => $hexCode
        ]);
    }

    /**
     * Update an existing record of expense category
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $hexCode
     * @return ExpenseCategory
     */
    public function updateExpenseCategory (int $id, string $name, string $hexCode): bool
    {
        return ExpenseCategory::where('id', $id)
            ->update([
                'name' => $name,
                'hex_code' => $hexCode
            ]);
    }

    /**
     * Delete one or multiple records of expense categories
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteExpenseCategories (array $ids): bool
    {
        return ExpenseCategory::whereIn('id', $ids)->delete();
    }
}