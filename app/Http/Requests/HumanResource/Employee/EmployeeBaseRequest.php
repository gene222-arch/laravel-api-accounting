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
            'employee_details.first_name' => 'first name',
            'employee_details.last_name' => 'last name',
            'employee_details.birth_date' => 'birth date',
            'role_id' => 'role',
            'salary_details.currency_id' => 'currency',
            'salary_details.tax_number' => 'tax number',
            'salary_details.bank_account_number' => 'bank account number',
            'salary_details.hired_at' => 'hire date'
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
