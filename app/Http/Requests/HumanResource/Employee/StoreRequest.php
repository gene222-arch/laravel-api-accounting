<?php

namespace App\Http\Requests\HumanResource\Employee;

use App\Http\Requests\HumanResource\Employee\EmployeeBaseRequest;

class StoreRequest extends EmployeeBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee.first_name' => ['required', 'string'],
            'employee.last_name' => ['required', 'string'],
            'employee.email' => ['required', 'email', 'unique:employees,email', 'unique:users,email'],
            'employee.birth_date' => ['required', 'date'],
            'employee.gender' => ['required', 'string', 'in:Male,Female'],
            'employee.phone' => ['required', 'string', 'min:11', 'max:15', 'unique:employees,phone'],
            'employee.address' => ['required', 'string'],
            'employee.image' => ['nullable', 'string'],
            'employee.enabled' => ['required', 'boolean'],
            'employee.role_id' => ['required', 'integer', 'exists:roles,id'],
            'salary.currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'salary.amount' => ['required', 'numeric', 'min:0'],
            'salary.tax_number' => ['required', 'string', 'min:9', 'max:11', 'unique:salaries,tax_number'],
            'salary.bank_account_number' => ['required', 'string', 'min:10', 'max:30', 'unique:salaries,bank_account_number'],
            'salary.hired_at' => ['required', 'date'],
            'create_user' => ['required', 'boolean'],
        ];
    }
}
