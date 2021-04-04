<?php

namespace App\Http\Requests\Settings\Currency;

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
            'name' => ['required', 'string', 'unique:currencies,name'],
            'code' => ['required', 'string', 'unique:currencies,code']
        ];
    }
}
