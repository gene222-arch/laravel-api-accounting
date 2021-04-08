<?php

namespace App\Http\Requests\HumanResource\Payroll\SalaryBenefit;

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
            'id' => ['required', 'integer', 'exists:salary_benefits,id'],
            'type' => ['required', 'string', 'unique:salary_benefits,type,' . $this->id],
            'amount' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
