<?php

namespace App\Http\Requests\InventoryManagement\Supplier;

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
            'id' => ['required', 'integer', 'exists:suppliers,id'],
            'name' => ['required', 'string', 'unique:suppliers,name,' . $this->id],
            'email' => ['required', 'email', 'unique:suppliers,email,' . $this->id],
            'phone' => ['required', 'string', 'unique:suppliers,phone,' . $this->id],
            'mainAddress' => ['required', 'string'],
            'optionalAddress' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'zipCode' => ['required', 'string', 'min:4', 'max:5'],
            'country' => ['required', 'string'],
            'province' => ['required', 'string'],
        ];
    }
}
