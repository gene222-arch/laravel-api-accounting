<?php

namespace App\Traits\HumanResource\Payroll\SalaryDeduction;

use App\Models\SalaryDeduction;
use Illuminate\Database\Eloquent\Collection;

trait SalaryDeductionsServices
{
    
    /**
     * Get latest records of salary deductions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSalaryDeductions (): Collection
    {
        return SalaryDeduction::latest()
            ->get([
                'id', 
                ...(new SalaryDeduction())->getFillable()
            ]);
    }
    
    /**
     * Get a record of salary deduction via id
     *
     * @param  int $id
     * @return SalaryDeduction|null
     */
    public function getSalaryDeductionById (int $id): SalaryDeduction|null
    {
        return SalaryDeduction::select(
            'id',
            ...(new SalaryDeduction())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of deductions of salaries
     *
     * @param  string $type
     * @param  float $rate
     * @param  bool $enabled
     * @return SalaryBenefit
     */
    public function createSalaryDeduction (string $type, float $rate, bool $enabled): SalaryDeduction
    {
        return SalaryDeduction::create([
            'type' => $type,
            'rate' => $rate,
            'enabled' => $enabled
        ]);
    }
    
    /**
     * Update an existing record of salary deductions
     *
     * @param  integer $id
     * @param  string $type
     * @param  float $amount
     * @param  bool $enabled
     * @return boolean
     */
    public function updateSalaryDeduction (int $id, string $type, float $rate, bool $enabled): bool
    {
        return SalaryDeduction::where('id', $id)
            ->update([
                'type' => $type,
                'rate' => $rate,
                'enabled' => $enabled
            ]);
    }

    /**
     * Delete one or multiple records of salary deductions
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteSalaryDeductions (array $ids): bool
    {
        return SalaryDeduction::whereIn('id', $ids)->delete();
    }
}