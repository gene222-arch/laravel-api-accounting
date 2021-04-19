<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccountType;

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
            'category' => ['required', 'string', 'in:Assets,Expenses,Liabilities,Incomes,Equity'],
            'name' => ['required', 'string', 'unique:chart_of_account_types,name'],
            'description' => ['nullable', 'string']
        ];
    }
}
