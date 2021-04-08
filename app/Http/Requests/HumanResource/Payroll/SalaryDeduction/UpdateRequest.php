<?php

namespace App\Http\Requests\HumanResource\Payroll\SalaryDeduction;

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
            'id' => ['required', 'integer', 'exists:salary_deductions,id'],
            'type' => ['required', 'string', 'unique:salary_deductions,type,' . $this->id],
            'rate' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
