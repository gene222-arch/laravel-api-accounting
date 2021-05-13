<?php

namespace App\Traits\HumanResource\Employee;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait EmployeesServices
{
    
    /**
     * Create a new record of employee
     *
     * @param  array $employee
     * @param  array $salary
     * @param  bool $create_user
     * @return mixed
     */
    public function createEmployee (array $employee, array $salary, bool $create_user = false): mixed
    {
        try {
            DB::transaction(function () use ($employee, $salary, $create_user)
            {
                $create_user && (
                    (new User())->createUserWithRoles(
                        $employee['first_name'],
                        $employee['last_name'],
                        $employee['email'],
                        $employee['first_name'],
                        $employee['role_id']
                ));

                $employee = Employee::create($employee);

                $employee->salary()->create($salary);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Create a new record of employee
     *
     * @param  Employee $employee
     * @param  array $employeeDetails
     * @param  array $salary
     * @param  bool $create_user
     * @return mixed
     */
    public function updateEmployee (Employee $employee, array $employeeDetails , array $salary, bool $create_user = false): mixed
    {
        try {
            DB::transaction(function () use ($employee, $employeeDetails , $salary, $create_user)
            {
                $user = User::where('email', $employee->email)->first();

                /** Delete user if it exists else create*/
                if (!$user)
                {
                    if ($create_user)
                    {
                        ((new User())->updateUserWithRolesByEmail(
                            $employeeDetails['email'],
                            $employeeDetails['first_name'],
                            $employeeDetails['last_name'],
                            $employeeDetails['email'],
                            $employeeDetails['first_name'],
                            $employeeDetails['role_id']
                        ));
                    }
                }
                else 
                {
                    if (!$create_user) $user->delete();
                }

                $employee->update($employeeDetails);

                $employee->salary()->update($salary);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}