<?php

namespace App\Traits\Item\Item;

use App\Models\Item;
use Illuminate\Support\Facades\DB;

trait ItemsServices
{
    
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
                $item = Item::create($itemData);
        
                if ($trackStock) {
                    $item->stock()->create($stockData);
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
     * @param  Item $item
     * @param  array $itemData
     * @param  array|null $stockData
     * @param  bool $trackStock
     * @return mixed
     */
    public function updateItem (Item $item, array $itemData, ?array $stockData, bool $trackStock): mixed
    {
        try {
            DB::transaction(function () use ($item, $itemData, $stockData, $trackStock) 
            {
                $item->update($itemData);
        
                if (!$trackStock) {
                    $item->stock()->delete();
                }

                $item->stock()->updateOrCreate($stockData);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
}