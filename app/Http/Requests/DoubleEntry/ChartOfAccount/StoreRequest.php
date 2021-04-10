<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccount;

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
            'name' => ['required', 'string', 'unique:chart_of_accounts,name'],
            'code' => ['required', 'string', 'unique:chart_of_accounts,code'],
            'type' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
