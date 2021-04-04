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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email,' . $this->id],
            'taxNumber' => ['required', 'integer', 'unique:customers,tax_number,' . $this->id],
            'currency' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:customers,phone,' . $this->id],
            'website' => ['nullable', 'url', 'string'],
            'address' => ['required', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }
}