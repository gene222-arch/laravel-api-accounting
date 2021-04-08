<?php

namespace App\Http\Requests\HumanResource\Employee;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:employees,id'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email,' . $this->id],
            'birthDate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:employees,phone,' . $this->id],
            'address' => ['required', 'string'],
            'roleId' => ['required', 'integer', 'exists:roles,id'],
            'enabled' => ['required', 'boolean'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'taxNumber' => ['required', 'string', 'min:9', 'max:11', 'unique:salaries,tax_number,' . $this->id],
            'bankAccountNumber' => ['required', 'string', 'min:10', 'max:30', 'unique:salaries,bank_account_number,' . $this->id],
            'hiredAt' => ['required', 'date'],
            'updateUser' => ['required', 'boolean'],
        ];
    }
    
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'birthDate' => 'birth date',
            'roleId' => 'role id',
            'enabled' => 'enabled',
            'currencyId' => 'currency id',
            'taxNumber' => 'tax number',
            'bankAccountNumber' => 'bank account number',
            'hiredAt' => 'hire date'
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
            'roleId.exists' => 'The selected :attribute does not exist.',
            'currencyId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
