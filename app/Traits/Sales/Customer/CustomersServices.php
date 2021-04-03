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
     * @param  string $name
     * @param  string $email
     * @param  integer $taxNumber
     * @param  string $currency
     * @param  string $phone
     * @param  string $website
     * @param  string $address
     * @param  string $reference
     * @return Customer
     */
    public function createCustomer (string $name, string $email, int $taxNumber, string $currency, string $phone, ?string $website, string $address, ?string $reference): Customer
    {
        return Customer::create([
            'name' => $name,
            'email' => $email,
            'tax_number' => $taxNumber,
            'currency' => $currency,            
            'phone' => $phone,
            'website' => $website,
            'address' => $address,
            'reference' => $reference
        ]);
    }
    
    /**
     * Update an existing record of customer
     *
     * @param integer $id
     * @param  string $name
     * @param  string $email
     * @param  integer $taxNumber
     * @param  string $currency
     * @param  string $phone
     * @param  string $website
     * @param  string $address
     * @param  string $reference
     * @return boolean
     */
    public function updateCustomer (int $id, string $name, string $email, int $taxNumber, string $currency, string $phone, ?string $website, string $address, ?string $reference): bool
    {
        $update = Customer::where('id', $id)
            ->update([
                'name' => $name,
                'email' => $email,
                'tax_number' => $taxNumber,
                'currency' => $currency,            
                'phone' => $phone,
                'website' => $website,
                'address' => $address,
                'reference' => $reference
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