<?php

namespace App\Http\Requests\InventoryManagement\Warehouse;

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
            'id' => ['required', 'integer', 'exists:warehouses,id'],
            'name' => ['required', 'string', 'unique:warehouses,name,' . $this->id],
            'email' => ['required', 'string', 'unique:warehouses,email,' . $this->id],
            'phone' => ['required', 'string', 'unique:warehouses,phone,' . $this->id],
            'address' => ['required', 'string'],
            'defaultWarehouse' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
