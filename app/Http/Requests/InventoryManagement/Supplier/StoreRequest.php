<?php

namespace App\Http\Requests\InventoryManagement\Supplier;

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
            'name' => ['required', 'string', 'unique:suppliers,name'],
            'email' => ['required', 'email', 'unique:suppliers,email'],
            'phone' => ['required', 'string', 'unique:suppliers,phone'],
            'mainAddress' => ['required', 'string'],
            'optionalAddress' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'zipCode' => ['required', 'string', 'min:4', 'max:5'],
            'country' => ['required', 'string'],
            'province' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
