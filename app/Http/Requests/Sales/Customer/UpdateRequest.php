<?php

namespace App\Http\Requests\Sales\Customer;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:customers,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email,' . $this->id],
            'taxNumber' => ['required', 'integer', 'unique:customers,tax_number,' . $this->id],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:customers,phone,' . $this->id],
            'website' => ['nullable', 'url', 'string'],
            'address' => ['required', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }

    /**
     * Rename attributes
     * 
     * return $array
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
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
