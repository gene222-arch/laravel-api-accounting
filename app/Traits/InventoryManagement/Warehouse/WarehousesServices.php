<?php

namespace App\Traits\InventoryManagement\Warehouse;

use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait WarehousesServices
{ 
    /**
     * Create a new record of warehouse
     *
     * @param  array $warehouseDetails
     * @param  array $stocks
     * @return mixed
     */
    public function createWarehouse (array $warehouseDetails, array $stocks): mixed
    {
        try {
            DB::transaction(function () use ($warehouseDetails, $stocks)
            {
                $warehouse = Warehouse::create($warehouseDetails);

                $warehouse->stocks()->attach($stocks);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of warehouse
     *
     * @param  Warehouse $warehouse
     * @param  array $warehouseDetails
     * @param  array $stocks
     * @return mixed
     */
    public function updateWarehouse (Warehouse $warehouse, array $warehouseDetails, array $stocks): mixed
    {
        try {
            DB::transaction(function () use ($warehouse, $warehouseDetails, $stocks)
            {
                $warehouse->update($warehouseDetails);

                $warehouse->stocks()->sync($stocks);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}
