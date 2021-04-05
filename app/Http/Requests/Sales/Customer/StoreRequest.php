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
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'taxNumber' => ['required', 'integer', 'unique:customers,tax_number'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:customers,phone'],
            'website' => ['nullable', 'url', 'string'],
            'address' => ['required', 'string'],
            'reference' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean']
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
        ];
    }
}
