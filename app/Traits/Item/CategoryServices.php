<?php

namespace App\Traits\Item;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

trait CategoriesServices
{

    /**
     * Get all latest records of categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories (): Collection
    {
        return Category::latest()->get([
            'id', 
            ...(new Category())->getFillable()
        ]);
    }
    
    /**
     * Get a record of category via id
     *
     * @param  int $id
     * @return Category|null
     */
    public function getCategoryById (int $id): Category|null
    {
        return Category::select(
            'id', 
            ...(new Category())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new record of category
     *
     * @param  string $name
     * @param  string $hexCode
     * @param  bool $enabled
     * @return Category
     */
    public function createCategory (string $name, string $hexCode, bool $enabled): Category
    {
        return Category::create([
            'name' => $name,
            'hex_code' => $hexCode,
            'enabled' => $enabled,
        ]);
    }
    
    /**
     * Update an existing record of category
     *
     * @param  int $id
     * @param  string $name
     * @param  string $hexCode
     * @param  bool $enabled
     * @return boolean
     */
    public function updateCategory (int $id, string $name, string $hexCode, bool $enabled): bool
    {
        $update = Category::where('id', $id)
            ->update([
                'name' => $name,
                'hex_code' => $hexCode,
                'enabled' => $enabled,
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