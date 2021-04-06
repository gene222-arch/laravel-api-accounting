<?php

namespace App\Http\Requests\InventoryManagement\Stock\StockAdjustment;

use App\Http\Requests\BaseRequest;
use App\Models\StockAdjustment;

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
            'stockAdjustmentNumber' => ['required', 'string', 'unique:stock_adjustments,stock_adjustment_number'],
            'reason' => ['required', 'string', "in:" . implode(',', StockAdjustment::adjustmentReasons())],
            'adjustmentDetails.*' => ['required', 'array', 'min:1']
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
            'stockAdjustmentNumber' => 'stock adjustment number',
            'adjustmentDetails' => 'adjustment details',
        ];
    }

}
