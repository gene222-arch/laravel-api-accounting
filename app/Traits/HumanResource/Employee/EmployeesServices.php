<?php

namespace App\Traits\HumanResource\Employee;

use App\Models\Employee;
use App\Models\User;
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
     * @param  string $firstName
     * @param  string $lastName
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
     * @param  bool $createUser
     * @return mixed
     */
    public function createEmployee (string $firstName, string $lastName, string $email, string $birthDate, string $gender, string $phone, string $address, int $roleId, bool $enabled, int $currencyId, float $amount, string $taxNumber, string $bankAccountNumber, string $hiredAt, bool $createUser = false): mixed
    {
        try {
            DB::transaction(function () use (
                $firstName, $lastName, $email, $birthDate, $gender, $phone, $address, $roleId, $enabled,
                $currencyId, $amount, $taxNumber, $bankAccountNumber, $hiredAt, $createUser
            )
            {
                $createUser && (
                    (new User())->createUserWithRoles(
                        $firstName,
                        $lastName,
                        $email,
                        $firstName,
                        $roleId
                ));

                $employee = Employee::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
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
     * @param  string $firstName
     * @param  string $lastName
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
     * @param  bool $updateUser
     * @return mixed
     */
    public function updateEmployee (int $id, string $firstName, string $lastName, string $email, string $birthDate, string $gender, string $phone, string $address, int $roleId, bool $enabled, int $currencyId, float $amount, string $taxNumber, string $bankAccountNumber, string $hiredAt, bool $updateUser): mixed
    {
        try {
            DB::transaction(function () use (
                $id, $firstName, $lastName, $email, $birthDate, $gender, $phone, $address, $roleId, $enabled,
                $currencyId, $amount, $taxNumber, $bankAccountNumber, $hiredAt, $updateUser
            )
            {
                $employee = Employee::find($id);

                $updateUser && (
                    (new User())->updateUserWithRolesByEmail(
                        $employee->email,
                        $firstName,
                        $lastName,
                        $email,
                        null,
                        $roleId
                ));

                $employee->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
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