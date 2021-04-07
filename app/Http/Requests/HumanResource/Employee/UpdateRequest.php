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
            'id' => ['required', 'integeer', 'exists:employees,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email,' . $this->id],
            'birthDate' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:Male,Female'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:employees,phone,' . $this->id],
            'address' => ['required', 'string'],
            'roleId' => ['required', 'integeer', 'exists:roles,id'],
            'enabled' => ['required'],
            'currencyId' => ['required', 'integeer', 'exists:currencies,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'taxNumber' => ['required', 'string', 'min:9', 'max:11', 'unique:employees,tax_number,' . $this->id],
            'bankAccountNumber' => ['required', 'string', 'min:10', 'max:30', 'unique:employees,bank_account_number,' . $this->id],
            'hiredAt' => ['required', 'date']
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
