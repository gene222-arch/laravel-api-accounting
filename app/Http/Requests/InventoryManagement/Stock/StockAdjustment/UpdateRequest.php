<?php

namespace App\Http\Requests\InventoryManagement\Stock\StockAdjustment;

use App\Models\StockAdjustment;
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
            'id' => ['required', 'integer', 'exists:stock_adjustments,id'],
            'stockAdjustmentNumber' => ['required', 'string', 'unique:stock_adjustments,stock_adjustment_number,' . $this->id],
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
