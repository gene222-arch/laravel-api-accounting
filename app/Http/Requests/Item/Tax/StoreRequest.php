<?php

namespace App\Http\Requests\Item\Tax;

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
            'name' => ['required', 'string', 'unique:taxes,name'],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'string', 'in:Normal,Compound,Fixed,Inclusive'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
