<?php

namespace App\Http\Requests\Purchases\Vendor;

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
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:vendors,email'],
            'taxNumber' => ['required', 'string', 'min:5', 'max:5', 'unique:vendors,tax_number'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:vendors,phone'],
            'website' => ['nullable', 'website'],
            'reference' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'currencyId' => 'currency id',
            'taxNumber' => 'tax number',
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currencyId.exists' => 'The selected :attribute does not exist.',
            'taxNumber.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
