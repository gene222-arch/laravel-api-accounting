<?php

namespace App\Http\Requests\Purchases\Vendor;

use App\Http\Requests\Purchases\Vendor\VendorBaseRequest;

class StoreRequest extends VendorBaseRequest
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
            'email' => ['required', 'email', 'unique:vendors,email'],
            'tax_number' => ['required', 'string', 'min:5', 'max:7', 'unique:vendors,tax_number'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:vendors,phone'],
            'website' => ['nullable', 'website'],
            'reference' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean'],
        ];
    }

}
