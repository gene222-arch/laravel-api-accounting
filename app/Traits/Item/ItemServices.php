<?php

namespace App\Traits\Item;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

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
            ...(new Item())->getFillable()
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
            ...(new Item())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record if item
     *
     * @param  int $categoryId
     * @param  string $sku
     * @param  string $barcode
     * @param  string $name
     * @param  string $description
     * @param  float $price
     * @param  float $cost
     * @param  string $soldBy
     * @param  bool $isForSale
     * @param  string $image
     * @return Item
     */
    public function createItem (int $categoryId, string $sku, string $barcode, string $name, ?string $description, float $price, float $cost, string $soldBy, bool $isForSale, string $image): Item
    {
        return Item::create([
            'category_id' => $categoryId,
            'sku' => $sku,
            'barcode' => $barcode,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'cost' => $cost,
            'sold_by' => $soldBy,
            'is_for_sale' => $isForSale,
            'image' => $image
        ]);
    }
    
    /**
     * Update an existing record of item
     *
     * @param  int $id
     * @param  int $categoryId
     * @param  string $sku
     * @param  string $barcode
     * @param  string $name
     * @param  string $description
     * @param  float $price
     * @param  float $cost
     * @param  string $soldBy
     * @param  bool $isForSale
     * @param  string $image
     * @return boolean
     */
    public function updateItem (int $id, int $categoryId, string $sku, string $barcode, string $name, ?string $description, float $price, float $cost, string $soldBy, bool $isForSale, string $image): bool
    {   
        Storage::delete($image);

        $update = Item::where('id', $id)
            ->update([
                'category_id' => $categoryId,
                'sku' => $sku,
                'barcode' => $barcode,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'cost' => $cost,
                'sold_by' => $soldBy,
                'is_for_sale' => $isForSale,
                'image' => $image
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
        $items = Item::whereIn('ids', $ids);

        $images = $items->pluck('image')->toArray();

        Storage::delete($images);
        
        return $items->delete();
    }
    
}