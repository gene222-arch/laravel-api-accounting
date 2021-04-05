<?php

namespace App\Traits\InventoryManagement\Warehouse;

use App\Models\Warehouse;
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
        return Warehouse::latest()->get([
            'id',
            ...(new Warehouse())->getFillable()
        ]);
    }
    
    /**
     * Get a record of warehouse via id
     *
     * @param  int $id
     * @return Warehouse|null
     */
    public function getWarehouseById (int $id): Warehouse|null
    {
        return Warehouse::select(
            'id', 
            ...(new Warehouse())->getFillable()
        )
            ->where('id', $id)
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
     * @return Warehouse
     */
    public function createWarehouse (string $name, string $email, string $phone, string $address, bool $defaultWarehouse, bool $enabled): Warehouse
    {
        return Warehouse::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'default_warehouse' => $defaultWarehouse,
            'updated_at' => null,
            'enabled' => $enabled
        ]);
    }
    
    /**
     * Update an existing record of warehouse
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  string $address
     * @param  bool $defaultWarehouse
     * @param  bool $enabled
     * @return boolean
     */
    public function updateWarehouse (int $id, string $name, string $email, string $phone, string $address, bool $defaultWarehouse, bool $enabled): bool
    {
        $update = Warehouse::where('id', $id)
            ->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'default_warehouse' => $defaultWarehouse,
                'enabled' => $enabled,
                'updated_at' => now()
            ]);

        return boolval($update);
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
