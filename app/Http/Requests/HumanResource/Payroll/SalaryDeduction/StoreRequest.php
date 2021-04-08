<?php

namespace App\Http\Requests\HumanResource\Payroll\SalaryDeduction;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', 'unique:salary_deductions,type'],
            'rate' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
