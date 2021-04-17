<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccount;

use App\Http\Requests\DoubleEntry\ChartOfAccount\ChartOfAccountBaseRequest;

class StoreRequest extends ChartOfAccountBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chart_of_account_type_id' => ['required', 'integer', 'exists:chart_of_account_types,id'],
            'name' => ['required', 'string', 'unique:chart_of_accounts,name'],
            'code' => ['required', 'string', 'unique:chart_of_accounts,code'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
