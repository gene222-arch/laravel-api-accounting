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
            'name' => ['required', 'string', 'unique:accounts,name'],
            'number' => ['required', 'integer', 'min:5', 'unique:accounts,number'],
            'currency' => ['required', 'string'],
            'openingBalance' => ['required', 'numberic', 'min:0']
        ];
    }
}
