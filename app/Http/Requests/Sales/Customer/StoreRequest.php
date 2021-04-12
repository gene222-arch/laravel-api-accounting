<?php

namespace App\Http\Requests\Sales\Customer;

use App\Http\Requests\Sales\Customer\CustomerBaseRequest;

class StoreRequest extends CustomerBaseRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'tax_number' => ['required', 'integer', 'unique:customers,tax_number'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:customers,phone'],
            'website' => ['nullable', 'url', 'string'],
            'address' => ['required', 'string'],
            'reference' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
