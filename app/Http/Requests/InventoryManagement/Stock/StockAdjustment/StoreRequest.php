<?php

namespace App\Http\Requests\InventoryManagement\Stock\StockAdjustment;

use App\Models\StockAdjustment;
use App\Http\Requests\InventoryManagement\Stock\StockAdjustment\StockAdjustmentBaseRequest;

class StoreRequest extends StockAdjustmentBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stock_adjustment_number' => ['required', 'string', 'unique:stock_adjustments,stock_adjustment_number'],
            'reason' => ['required', 'string', "in:" . implode(',', StockAdjustment::adjustmentReasons())],
            'adjustment_details.*' => ['required', 'array', 'min:1'],
            'adjustment_details.*.stock_id' => ['required', 'integer', 'distinct', 'exists:stocks,id'],
        ];
    }

}
