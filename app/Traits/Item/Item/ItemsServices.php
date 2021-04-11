<?php

namespace App\Traits\Item\Item;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

trait ItemsServices
{
    
    /**
     * Create a new record of item
     *
     * @param  array $itemData
     * @param  array|null $stockData
     * @param  array|null $taxes
     * @param  bool $trackStock
     * @return mixed
     */
    public function createItem (array $itemData, ?array $stockData, array $taxes, bool $trackStock): mixed
    {
        try {
            DB::transaction(function () use ($itemData, $stockData, $trackStock, $taxes) 
            {
                $item = Item::create($itemData);

                if ($taxes) $item->taxes()->attach($taxes);
        
                if ($trackStock)  $item->stock()->create($stockData);

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of item
     *
     * @param  integer $id
     * @param  array $itemData
     * @param  array|null $stockData
     * @param  array|null $taxes
     * @param  bool $trackStock
     * @return mixed
     */
    public function updateItem (int $id, array $itemData, ?array $stockData, array $taxes, bool $trackStock): mixed
    {
        try {
            DB::transaction(function () use ($id, $itemData, $stockData, $trackStock, $taxes) 
            {
                $item = Item::find($id);

                $item->update($itemData);

                if ($taxes) $item->taxes()->sync($taxes);
        
                if ($trackStock)  $item->stock()->update($stockData);

            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
}