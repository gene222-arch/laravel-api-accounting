<?php

namespace App\Traits\HumanResource\Employee;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait EmployeesServices
{
    
    /**
     * Get latest records of Employees
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEmployees (): Collection
    {
        return Employee::with('salary')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of employee via id
     *
     * @param  int $id
     * @return Employee|null
     */
    public function getEmployeeById (int $id): Employee|null
    {
        return Employee::where('id', $id)
            ->with('salary')
            ->first();
    }
    
    /**
     * Create a new record of employee
     *
     * @param  string $name
     * @param  string $email
     * @param  string $birthDate
     * @param  string $gender
     * @param  string $phone
     * @param  string $address
     * @param  integer $roleId
     * @param  bool $enabled
     * @param  integer $currencyId
     * @param  float $amount
     * @param  string $taxNumber
     * @param  string $bankAccountNumber
     * @param  string $hiredAt
     * @return mixed
     */
    public function createEmployee (string $name, string $email, string $birthDate, string $gender, string $phone, string $address, int $roleId, bool $enabled, int $currencyId, float $amount, string $taxNumber, string $bankAccountNumber, string $hiredAt): mixed
    {
        try {
            DB::transaction(function () use (
                $name, $email, $birthDate, $gender, $phone, $address, $roleId, $enabled,
                $currencyId, $amount, $taxNumber, $bankAccountNumber, $hiredAt
            )
            {
                $employee = Employee::create([
                    'name' => $name,
                    'email' => $email,
                    'birth_date' => $birthDate,
                    'gender' => $gender,
                    'phone' => $phone,
                    'address' => $address,
                    'enabled' => $enabled
                ]);

                $employee->salary()->create([
                    'currency_id' => $currencyId,
                    'amount' => $amount,
                    'tax_number' => $taxNumber,
                    'bank_account_number' => $bankAccountNumber,
                    'hired_at' => $hiredAt
                ]);

                $employee->assignRole($roleId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of employee
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $email
     * @param  string $birthDate
     * @param  string $gender
     * @param  string $phone
     * @param  string $address
     * @param  integer $roleId
     * @param  bool $enabled
     * @param  integer $currencyId
     * @param  float $amount
     * @param  string $taxNumber
     * @param  string $bankAccountNumber
     * @param  string $hiredAt
     * @return mixed
     */
    public function updateEmployee (int $id, string $name, string $email, string $birthDate, string $gender, string $phone, string $address, int $roleId, bool $enabled, int $currencyId, float $amount, string $taxNumber, string $bankAccountNumber, string $hiredAt): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $name, $email, $birthDate, $gender, $phone, $address, $roleId, $enabled,
                $currencyId, $amount, $taxNumber, $bankAccountNumber, $hiredAt
            )
            {
                $employee = Employee::find($id);

                $employee->update([
                    'name' => $name,
                    'email' => $email,
                    'birth_date' => $birthDate,
                    'gender' => $gender,
                    'phone' => $phone,
                    'address' => $address,
                    'enabled' => $enabled
                ]);

                $employee->salary()->update([
                    'currency_id' => $currencyId,
                    'amount' => $amount,
                    'tax_number' => $taxNumber,
                    'bank_account_number' => $bankAccountNumber,
                    'hired_at' => $hiredAt
                ]);

                $employee->syncRole($roleId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of employees
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteEmployees (array $ids): bool
    {
        return Employee::whereIn('id', $ids)->delete();
    }
}