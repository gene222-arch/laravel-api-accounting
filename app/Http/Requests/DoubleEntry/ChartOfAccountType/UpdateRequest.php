<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccountType;

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
            'id' => ['required', 'integer', 'exists:chart_of_account_types,id'],
            'category' => ['required', 'string', 'in:Asset,Liability,Equity'],
            'name' => ['required', 'string', 'unique:chart_of_account_types,name,' . $this->id],
            'description' => ['nullable', 'string']
        ];
    }
}
