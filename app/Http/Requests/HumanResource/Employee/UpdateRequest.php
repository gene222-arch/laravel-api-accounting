<?php

namespace App\Http\Requests\HumanResource\Employee;

use App\Http\Requests\HumanResource\Employee\EmployeeBaseRequest;
use App\Models\Employee;

class UpdateRequest extends EmployeeBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * Todo: create a rule for unique salary details
     *
     * @return array
     */
    public function rules()
    {
        $employeeSalaryId = Employee::find($this->id)->salary->id;

        return [
            'id' => ['required', 'integer', 'exists:employees,id'],
            'employee_details.first_name' => ['required', 'string'],
            'employee_details.last_name' => ['required', 'string'],
            'employee_details.email' => ['required', 'email', 'unique:employees,email,' . $this->id],
            'employee_details.birth_date' => ['required', 'date'],
            'employee_details.gender' => ['required', 'string', 'in:Male,Female'],
            'employee_details.phone' => ['required', 'string', 'min:11', 'max:15', 'unique:employees,phone,' . $this->id],
            'employee_details.address' => ['required', 'string'],
            'employee_details.enabled' => ['required', 'boolean'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'salary_details.currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'salary_details.amount' => ['required', 'numeric', 'min:0'],
            'salary_details.tax_number' => ['required', 'string', 'min:9', 'max:11', 'unique:salaries,tax_number,' . $employeeSalaryId],
            'salary_details.bank_account_number' => ['required', 'string', 'min:10', 'max:30', 'unique:salaries,bank_account_number,' . $employeeSalaryId],
            'salary_details.hired_at' => ['required', 'date'],
            'create_user' => ['required', 'boolean'],
        ];
    }
}
