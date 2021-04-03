<?php

namespace App\Traits\Item;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

trait ItemServices
{
    
    /**
     * Get all latest records if items
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllItems (): Collection
    {
        return Item::latest()->get([
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
     * Create a new record of item
     *
     * @param  array $itemData
     * @param  array|null $stockData
     * @param  bool $trackStock
     * @return mixed
     */
    public function createItem (array $itemData, ?array $stockData, bool $trackStock): mixed
    {
        try {
            DB::transaction(function () use ($itemData, $stockData, $trackStock) 
            {
                $item = Item::create([
                    'category_id' => $itemData['categoryId'],
                    'sku' => $itemData['sku'],
                    'barcode' => $itemData['barcode'],
                    'name' => $itemData['name'],
                    'description' => $itemData['description'],
                    'price' => $itemData['price'],
                    'cost' => $itemData['cost'],
                    'sold_by' => $itemData['soldBy'],
                    'is_for_sale' => $itemData['isForSale'],
                    'image' => $itemData['image']
                ]);

                if ($itemData['taxes'])
                {
                    $item->taxes()->attach($itemData['taxes']);
                }
        
                if ($trackStock)
                {
                    $item->stock()->create([
                        'supplier_id' => $stockData['supplierId'],
                        'warehouse_id' => $stockData['warehouseId'],
                        'in_stock' => $stockData['inStock'],
                        'minimum_stock' => $stockData['minimumStock']
                    ]);
                }

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of item
     *
     * @param  array $itemData
     * @param  array|null $stockData
     * @param  bool $trackStock
     * @return mixed
     */
    public function updateItem (array $itemData, ?array $stockData, bool $trackStock): mixed
    {   
        try {
            DB::transaction(function () use ($itemData, $stockData, $trackStock)
            {
                $item = Item::find($itemData['id']);

                $item->update([
                    'category_id' => $itemData['categoryId'],
                    'sku' => $itemData['sku'],
                    'barcode' => $itemData['barcode'],
                    'name' => $itemData['name'],
                    'description' => $itemData['description'],
                    'price' => $itemData['price'],
                    'cost' => $itemData['cost'],
                    'sold_by' => $itemData['soldBy'],
                    'is_for_sale' => $itemData['isForSale'],
                    'image' => $itemData['image']
                ]);

                if ($itemData['taxes'])
                {
                    $item->taxes()->attach($itemData['taxes']);
                }

                if ($trackStock)
                {
                    $item->stock()->updateOrCreate([
                        'supplier_id' => $stockData['supplierId'],
                        'warehouse_id' => $stockData['warehouseId'],
                        'in_stock' => $stockData['inStock'],
                        'minimum_stock' => $stockData['minimumStock']
                    ]);
                }

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Delete one or multiple existing records of taxes
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteItems (array $ids): bool
    {
        $items = Item::whereIn('id', $ids);

        $images = $items->pluck('image')->toArray();

        Storage::delete($images);
        
        return $items->delete();
    }
    
}