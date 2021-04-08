<?php

namespace App\Traits\HumanResource\Payroll\SalaryBenefit;

use App\Models\SalaryBenefit;
use Illuminate\Database\Eloquent\Collection;

trait SalaryBenefitsServices
{
    
    /**
     * Get latest records of salary benefits
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSalaryBenefits (): Collection
    {
        return SalaryBenefit::latest()
            ->get([
                'id', 
                ...(new SalaryBenefit())->getFillable()
            ]);
    }
    
    /**
     * Get a record of salary benefit via id
     *
     * @param  int $id
     * @return SalaryBenefit|null
     */
    public function getSalaryBenefitById (int $id): SalaryBenefit|null
    {
        return SalaryBenefit::select(
            'id',
            ...(new SalaryBenefit())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of benefits of salaries
     *
     * @param  string $type
     * @param  float $amount
     * @param  bool $enabled
     * @return SalaryBenefit
     */
    public function createSalaryBenefit (string $type, float $amount, bool $enabled): SalaryBenefit
    {
        return SalaryBenefit::create([
            'type' => $type,
            'amount' => $amount,
            'enabled' => $enabled
        ]);
    }
        
    /**
     * Update an existing record of salary benefits
     *
     * @param  integer $id
     * @param  string $type
     * @param  float $amount
     * @param  bool $enabled
     * @return boolean
     */
    public function updateSalaryBenefit (int $id, string $type, float $amount, bool $enabled): bool
    {
        return SalaryBenefit::where('id', $id)
            ->update([
                'type' => $type,
                'amount' => $amount,
                'enabled' => $enabled
            ]);
    }

    /**
     * Delete one or multiple records of salary benefits
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteSalaryBenefits (array $ids): bool
    {
        return SalaryBenefit::whereIn('id', $ids)->delete();
    }
}