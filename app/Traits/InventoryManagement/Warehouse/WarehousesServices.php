<?php

namespace App\Traits\InventoryManagement\Warehouse;

use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait WarehousesServices
{
    
    /**
     * Get all latest records of warehouses
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWarehouses (): Collection
    {
        return Warehouse::with('stocks.item')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of warehouse via id
     *
     * @param  int $id
     * @return Warehouse|null
     */
    public function getWarehouseById (int $id): Warehouse|null
    {
        return Warehouse::where('id', $id)
            ->with('stocks.item')
            ->first();
    }
    
    /**
     * Create a new record of warehouse
     *
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  string $address
     * @param  bool $defaultWarehouse
     * @param  bool $enabled
     * @param  array $stocks
     * @return mixed
     */
    public function createWarehouse (string $name, string $email, string $phone, string $address, bool $defaultWarehouse, bool $enabled, array $stocks): mixed
    {
        try {
            DB::transaction(function () use ($name, $email, $phone, $address, $defaultWarehouse, $enabled, $stocks)
            {
                $warehouse = Warehouse::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'default_warehouse' => $defaultWarehouse,
                    'updated_at' => null,
                    'enabled' => $enabled
                ]);

                $warehouse->stocks()->attach($stocks);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of warehouse
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  string $address
     * @param  bool $defaultWarehouse
     * @param  bool $enabled
     * @param  array $stocks
     * @return mixed
     */
    public function updateWarehouse (int $id, string $name, string $email, string $phone, string $address, bool $defaultWarehouse, bool $enabled, array $stocks): mixed
    {
        try {
            DB::transaction(function () use ($id, $name, $email, $phone, $address, $defaultWarehouse, $enabled, $stocks)
            {
                $warehouse = Warehouse::find($id);

                $warehouse->update([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'default_warehouse' => $defaultWarehouse,
                    'updated_at' => null,
                    'enabled' => $enabled
                ]);

                $warehouse->stocks()->sync($stocks);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Delete one or multiple records of warehouses
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteWarehouses (array $ids): bool
    {
        return Warehouse::whereIn('id', $ids)->delete();
    }
}
