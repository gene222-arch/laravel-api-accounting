<?php

namespace App\Http\Requests\Banking\Account;

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
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string', 'unique:accounts,name'],
            'number' => ['required', 'integer', 'min:5', 'unique:accounts,number'],
            'openingBalance' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
