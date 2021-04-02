<?php

namespace App\Traits\Item;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

trait CategoryServices
{

    /**
     * Get all records of categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories (): Collection
    {
        return Category::all(['id', 'name', 'hex_code']);
    }
    
    /**
     * Get a record of category
     *
     * @param  int $id
     * @return Category|null
     */
    public function getCategoryById (int $id): Category|null
    {
        return Category::select('id', 'name', 'hex_code')
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new record of category
     *
     * @param  string $name
     * @param  string $hexCode
     * @return Category
     */
    public function createCategory (string $name, string $hexCode): Category
    {
        return Category::create([
            'name' => $name,
            'hex_code' => $hexCode
        ]);
    }
    
    /**
     * Update an existing record of category
     *
     * @param  int $id
     * @param  string $name
     * @param  string $hexCode
     * @return boolean
     */
    public function updateCategory (int $id, string $name, string $hexCode): bool
    {
        $update = Category::where('id', $id)
            ->update([
                'name' => $name,
                'hex_code' => $hexCode
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of categories
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteCategories (array $ids): bool
    {
        return Category::whereIn('id', $ids)->delete();
    }
}