<?php

namespace App\Traits\Banking\BankAccountReconciliation;

use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;

trait DeleteRequest
{
    
    /**
     * Get latest records of customers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomers (): Collection
    {
        return Model::latest()
            ->get([
                'id', 
                ...(new Model())->getFillable()
            ]);
    }
    
    /**
     * Get a record of customer via id
     *
     * @param  int $id
     * @return Model|null
     */
    public function getCustomerById (int $id): Model|null
    {
        return Model::select(
            'id',
            ...(new Model())->getFillable()
        )
        ->where('id', $id)
        ->first();
    }
    

    public function createCustomer (): Model
    {
        return Model::create([
            'data' => 'data'
        ]);
    }
    
    public function updateCustomer (int $id): bool
    {
        return Model::where('id', $id)
            ->update([
                'data' => 'data'
            ]);
    }

    /**
     * Delete one or multiple records of customers
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteCustomers (array $ids): bool
    {
        return Model::whereIn('id', $ids)->delete();
    }
}