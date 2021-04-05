<?php

namespace App\Traits\Purchases\Vendor;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;

trait VendorsServices
{
    
    /**
     * Get latest records of vendors
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllVendors (): Collection
    {
        return Vendor::latest()
            ->get([
                'id', 
                ...(new Vendor())->getFillable()
            ]);
    }
    
    /**
     * Get a record of vendor via id
     *
     * @param  int $id
     * @return Vendor|null
     */
    public function getVendorById (int $id): Vendor|null
    {
        return Vendor::select(
            'id',
            ...(new Vendor())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
        
    /**
     * Create a new record of vendor
     *
     * @param  integer $currencyId
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  integer $taxNumber
     * @param  string|null $website
     * @param  string $address
     * @param  string|null $reference
     * @param  string|null $image
     * @param  bool $enabled
     * @return Vendor
     */
    public function createVendor (int $currencyId, string $name, string $email, string $phone, int $taxNumber, ?string $website, string $address, ?string $reference, ?string $image, bool $enabled): Vendor
    {
        return Vendor::create([
            'currency_id' => $currencyId,
            'name' => $name,
            'email' => $email,
            'tax_number' => $taxNumber,
            'phone' => $phone,
            'website' => $website,
            'address' => $address,
            'reference' => $reference,
            'image' => $image,
            'enabled' => $enabled,
        ]);
    }

    /**
     * Update an existing record of vendor
     *
     * @param  integer $currencyId
     * @param  string $name
     * @param  string $email
     * @param  string $phone
     * @param  integer $taxNumber
     * @param  string|null $website
     * @param  string $address
     * @param  string|null $reference
     * @param  string|null $image
     * @param  bool $enabled
     * @return Vendor
     */
    public function updateVendor (int $id, int $currencyId, string $name, string $email, string $phone, int $taxNumber, ?string $website, string $address, ?string $reference, ?string $image, bool $enabled): bool
    {
        $update = Vendor::where('id', $id)
            ->update([
                'currency_id' => $currencyId,
                'name' => $name,
                'email' => $email,
                'tax_number' => $taxNumber,
                'phone' => $phone,
                'website' => $website,
                'address' => $address,
                'reference' => $reference,
                'image' => $image,
                'enabled' => $enabled,
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of Vendors
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteVendors (array $ids): bool
    {
        return Vendor::whereIn('id', $ids)->delete();
    }
}