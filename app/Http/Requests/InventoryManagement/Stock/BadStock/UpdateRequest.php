<?php

namespace App\Http\Requests\InventoryManagement\Stock\BadStock;

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
            return [
            'id' => ['required', 'integer', 'exists:bad_stocks,id'],
            'badStockNumber' => ['required', 'string', 'unique:bad_stocks,stock_adjustment_number'],
            'reason' => ['required', 'string', "in:" . implode(',', StockAdjustment::adjustmentReasons())],
            'badStockDetails.*' => ['required', 'array', 'min:1']
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
            'badStockNumber' => 'bad stock number',
            'badStockDetails' => 'bad stock details',
        ];
    }
}
