<?php

namespace App\Http\Requests\InventoryManagement\Warehouse;

use App\Http\Requests\BaseRequest;

class WarehouseBaseRequest extends BaseRequest
{    
    /**
     * Rename attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'default_warehouse' => 'default warehouse'
        ];
    }
}
