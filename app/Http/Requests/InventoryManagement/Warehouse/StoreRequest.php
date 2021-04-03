<?php

namespace App\Http\Requests\InventoryManagement\Warehouse;

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
            'name' => ['required', 'string', 'unique:warehouses,name'],
            'email' => ['required', 'string', 'unique:warehouses,email'],
            'phone' => ['required', 'string', 'unique:warehouses,phone'],
            'address' => ['required', 'string'],
            'defaultWarehouse' => ['required', 'boolean']
        ];
    }
}
