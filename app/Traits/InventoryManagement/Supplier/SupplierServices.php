<?php

namespace App\Traits\InventoryManagement\Supplier;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;

trait SupplierServices
{
    
    /**
     * Get all records of suppliers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSuppliers (): Collection
    {
        return Supplier::all(['id', ...(new Supplier())->getFillable()]);
    }
    
    /**
     * Get a record of supplier via id
     *
     * @param  integer $id
     * @return Supplier|null
     */
    public function getSupplierById (int $id): Supplier|null
    {
        $supplier = new Supplier;

        return $supplier->select('id', ...$supplier->getFillable())
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of supplier
     *
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  string $mainAddress
     * @param  string $optionalAddress
     * @param  string $city
     * @param  integer $zipCode
     * @param  string $country
     * @param  string $province
     * @return Supplier
     */
    public function createSupplier (string $name, string $email, string $phone, string $mainAddress, string $optionalAddress, string $city, int $zipCode, string $country, string $province): Supplier
    {
        return Supplier::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'main_address' => $mainAddress,
            'optional_address' => $optionalAddress,
            'city' => $city,
            'zip_code' => $zipCode,
            'country' => $country,
            'province' => $province,
            'updated_at' => null
        ]);
    }
    
    /**
     * Update an existing record of supplier
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  string $mainAddress
     * @param  string $optionalAddress
     * @param  string $city
     * @param  integer $zipCode
     * @param  string $country
     * @param  string $province
     * @return Supplier
     */
    public function updateSupplier (int $id, string $name, string $email, string $phone, string $mainAddress, string $optionalAddress, string $city, int $zipCode, string $country, string $province)
    {
        $update = Supplier::where('id', $id)
            ->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'main_address' => $mainAddress,
                'optional_address' => $optionalAddress,
                'city' => $city,
                'zip_code' => $zipCode,
                'country' => $country,
                'province' => $province,
                'updated_at' => now()
            ]);

        return boolval($update);
    }   
    
    /**
     * Delete one or multiple records of categories
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteSuppliers (array $ids): bool
    {
        return Supplier::whereIn('id', $ids)->delete();
    }
}