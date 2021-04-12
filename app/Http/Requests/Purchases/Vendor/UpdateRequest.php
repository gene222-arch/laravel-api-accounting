<?php

namespace App\Http\Requests\Purchases\Vendor;

use App\Http\Requests\Purchases\Vendor\VendorBaseRequest;

class UpdateRequest extends VendorBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:vendors,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:vendors,email,' . $this->id],
            'tax_number' => ['required', 'string', 'min:5', 'max:5', 'unique:vendors,tax_number,' . $this->id],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:vendors,phone,' . $this->id],
            'website' => ['nullable', 'website'],
            'reference' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean'],
        ];
    }
}
