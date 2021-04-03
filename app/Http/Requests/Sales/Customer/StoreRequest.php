<?php

namespace App\Http\Requests\Sales\Customer;

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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'taxNumber' => ['required', 'integer', 'unique:customers,tax_number'],
            'currency' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:customers,phone'],
            'website' => ['nullable', 'url', 'string'],
            'address' => ['required', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }
}
