<?php

namespace App\Http\Requests\Banking\Account;

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
            'id' => ['required', 'integer', 'exists:accounts,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string', 'unique:accounts,name,' . $this->id],
            'number' => ['required', 'integer', 'min:5', 'unique:accounts,number,' . $this->id],
            'opening_balance' => ['required', 'numeric', 'min:0'],
            'balance' => ['required', 'numeric', 'min:0'],
            'bank_name' => ['required', 'string'],
            'bank_phone' => ['required', 'string', 'min:11', 'max:16'],
            'bank_address' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
