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
     * @param  array $employee_details
     * @param  integer $role_id
     * @param  array $salary_details
     * @param  bool $create_user
     * @return mixed
     */
    public function createEmployee (array $employee_details, int $role_id, array $salary_details, bool $create_user = false): mixed
    {
        try {
            DB::transaction(function () use ($employee_details, $role_id, $salary_details, $create_user)
            {
                $create_user && (
                    (new User())->createUserWithRoles(
                        $employee_details['first_name'],
                        $employee_details['last_name'],
                        $employee_details['email'],
                        $employee_details['first_name'],
                        $role_id
                ));

                $employee = Employee::create($employee_details);

                $employee->salary()->create($salary_details);
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
     * @param  array $employee_details
     * @param  integer $role_id
     * @param  array $salary_details
     * @param  bool $create_user
     * @return mixed
     */
    public function updateEmployee (Employee $employee, array $employee_details, int $role_id, array $salary_details, bool $create_user = false): mixed
    {
        try {
            DB::transaction(function () use ($employee, $employee_details, $role_id, $salary_details, $create_user)
            {
                $user = User::where('email', $employee->email)->first();

                /** Delete user if it exists else create*/
                if (!$user)
                {
                    if ($create_user)
                    {
                        ((new User())->updateUserWithRolesByEmail(
                            $employee_details['email'],
                            $employee_details['first_name'],
                            $employee_details['last_name'],
                            $employee_details['email'],
                            $employee_details['first_name'],
                            $role_id
                        ));
                    }
                }
                else 
                {
                    if (!$create_user) $user->delete();
                }

                $employee->update($employee_details);

                $employee->salary()->update($salary_details);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}