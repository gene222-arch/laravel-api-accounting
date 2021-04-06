<?php

namespace App\Http\Requests\InventoryManagement\Stock\StockAdjustment;

use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids.*' => ['required', 'integer', 'distinct', 'exists:stock_adjustments,id']
        ];
    }
}
