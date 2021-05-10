<?php

namespace App\Http\Requests\InventoryManagement\Warehouse;

use App\Http\Requests\InventoryManagement\Warehouse\WarehouseBaseRequest;

class StoreRequest extends WarehouseBaseRequest
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
            'default_warehouse' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean'],
            'stocks' => ['required', 'array', 'min:1'],
            'stocks.*.stock_id' => ['required', 'integer', 'distinct', 'exists:stocks,id']
        ];
    }
}
