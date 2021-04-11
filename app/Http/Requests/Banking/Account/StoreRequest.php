<?php

namespace App\Http\Requests\Banking\Account;

use App\Http\Requests\Banking\Account\AccountBaseRequest;

class StoreRequest extends AccountBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string', 'unique:accounts,name'],
            'number' => ['required', 'integer', 'min:5', 'unique:accounts,number'],
            'opening_balance' => ['required', 'numeric', 'min:0'],
            'balance' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
