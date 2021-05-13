<?php

namespace App\Http\Requests\HumanResource\Employee;

use App\Http\Requests\BaseRequest;

class EmployeeBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'employee.first_name' => 'first name',
            'employee.last_name' => 'last name',
            'employee.birth_date' => 'birth date',
            'employee.email' => 'email',
            'employee.phone' => 'phone',
            'employee.address' => 'address',
            'employee.gender' => 'gender',
            'employee.role_id' => 'position',
            'salary.currency_id' => 'currency',
            'salary.tax_number' => 'tax number',
            'salary.bank_account_number' => 'bank account number',
            'salary.hired_at' => 'hire date'
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role_id.exists' => 'The selected :attribute does not exist.',
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
