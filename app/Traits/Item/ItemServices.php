<?php

namespace App\Traits\Item;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

trait ItemServices
{
    
    /**
     * Get all records if items
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllItems (): Collection
    {
        return Item::all([
            'id',
            'category_id',
            'sku',
            'barcode',
            'name',
            'description',
            'price',
            'cost',
            'sold_by',
            'is_for_sale'
        ]);
    }

    /**
     * Get a record of item via id
     *
     * @param  int $id
     * @return Item|null
     */
    public function getItemById (int $id): Item|null
    {
        return Item::select(
            'id',
            'category_id',
            'sku',
            'barcode',
            'name',
            'description',
            'price',
            'cost',
            'sold_by',
            'is_for_sale'
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record if item
     *
     * @param  int $category_id
     * @param  string $sku
     * @param  string $barcode
     * @param  string $name
     * @param  string $description
     * @param  float $price
     * @param  float $cost
     * @param  string $sold_by
     * @param  bool $is_for_sale
     * @return Item
     */
    public function createItem (int $category_id, string $sku, string $barcode, string $name, ?string $description, float $price, float $cost, string $sold_by, bool $is_for_sale): Item
    {
        return Item::create([
            'category_id' => $category_id,
            'sku' => $sku,
            'barcode' => $barcode,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'cost' => $cost,
            'sold_by' => $sold_by,
            'is_for_sale' => $is_for_sale
        ]);
    }
    
    /**
     * Update an existing record of item
     *
     * @param  int $id
     * @param  int $category_id
     * @param  string $sku
     * @param  string $barcode
     * @param  string $name
     * @param  string $description
     * @param  float $price
     * @param  float $cost
     * @param  string $sold_by
     * @param  bool $is_for_sale
     * @return boolean
     */
    public function updateItem (int $id, int $category_id, string $sku, string $barcode, string $name, ?string $description, float $price, float $cost, string $sold_by, bool $is_for_sale): bool
    {   
        $update = Item::where('id', $id)
            ->update([
                'category_id' => $category_id,
                'sku' => $sku,
                'barcode' => $barcode,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'cost' => $cost,
                'sold_by' => $sold_by,
                'is_for_sale' => $is_for_sale
            ]);

        return boolval($update);
    }
    
    /**
     * Delete one or multiple existing records of taxes
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteItems (array $ids): bool
    {
        return Item::whereIn('id', $ids)->delete();
    }
    
}