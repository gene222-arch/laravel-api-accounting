<?php

namespace App\Http\Requests\InventoryManagement\Stock\StockAdjustment;

use App\Http\Requests\BaseRequest;

class StockAdjustmentBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'stock_adjustment_number' => 'stock adjustment number',
            'adjustment_details' => 'adjustment details',
            'adjustment_details.*.stock_id' => 'stock'
        ];
    }
}
