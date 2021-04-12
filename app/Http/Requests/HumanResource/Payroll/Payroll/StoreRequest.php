<?php

namespace App\Http\Requests\HumanResource\Payroll\Payroll;

use App\Http\Requests\HumanResource\Payroll\Payroll\PayrollBaseRequest;

class StoreRequest extends PayrollBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:payrolls,name'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date'],
            'payment_date' => ['required', 'date'],
            'status' => ['required', 'string'],
            'details.*' => ['required', 'array', 'min:1'],
            'taxes.*' => ['nullable', 'array', 'min:1'],
            'benefits.*' => ['nullable', 'array', 'min:1'],
            'contributions.*' => ['nullable', 'array', 'min:1'],
        ];
    }
}
