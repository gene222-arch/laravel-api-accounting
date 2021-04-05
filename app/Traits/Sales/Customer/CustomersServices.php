<?php

namespace App\Traits\Sales\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

trait CustomersServices
{
    
    /**
     * Get latest records of customers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomers (): Collection
    {
        return Customer::latest()->get([
            'id',
            ...(new Customer())->getFillable()
        ]);
    }
    
    /**
     * Get a record of customer via id
     *
     * @param  int $id
     * @return Customer|null
     */
    public function getCustomerById (int $id): Customer|null
    {
        return Customer::select(
            'id',
            ...(new Customer())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    
    /**
     * Create a new record of customer
     *
     * @param  integer $currencyId
     * @param  string $name
     * @param  string $email
     * @param  integer $taxNumber
     * @param  string $phone
     * @param  string $website
     * @param  string $address
     * @param  string $reference
     * @param  bool $enabled
     * @return Customer
     */
    public function createCustomer (int $currencyId, string $name, string $email, int $taxNumber, string $phone, ?string $website, string $address, ?string $reference, bool $enabled): Customer
    {
        return Customer::create([
            'currency_id' => $currencyId,         
            'name' => $name,
            'email' => $email,
            'tax_number' => $taxNumber,   
            'phone' => $phone,
            'website' => $website,
            'address' => $address,
            'reference' => $reference,
            'enabled' => $enabled
        ]);
    }
    
    /**
     * Update an existing record of customer
     *
     * @param  integer $id
     * @param  integer $currencyId
     * @param  string $name
     * @param  string $email
     * @param  integer $taxNumber
     * @param  string $phone
     * @param  string $website
     * @param  string $address
     * @param  string $reference
     * @param  bool $enabled
     * @return boolean
     */
    public function updateCustomer (int $id, int $currencyId, string $name, string $email, int $taxNumber, string $phone, ?string $website, string $address, ?string $reference, bool $enabled): bool
    {
        $update = Customer::where('id', $id)
            ->update([
                'currency_id' => $currencyId,    
                'name' => $name,
                'email' => $email,
                'tax_number' => $taxNumber,        
                'phone' => $phone,
                'website' => $website,
                'address' => $address,
                'reference' => $reference,
                'enabled' => $enabled
            ]);

        return boolval($update);
    }

    /**
     * Delete one or multiple records of customers
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteCustomers (array $ids): bool
    {
        return Customer::whereIn('id', $ids)->delete();
    }
}