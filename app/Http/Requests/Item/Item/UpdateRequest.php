<?php

namespace App\Http\Requests\Item\Item;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends ItemBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:items,id'],
            'item.category_id' => ['required', 'integer', 'exists:categories,id'],
            'item.sku' => ['required', 'string', 'min:8', 'max:12', 'unique:items,sku,' . $this->id],
            'item.barcode' => ['required', 'string', 'min:3', 'max:12', 'unique:items,barcode,' . $this->id],
            'item.name' => ['required', 'string', 'unique:items,name,' . $this->id],
            'item.description' => ['nullable', 'string'],
            'item.price' => ['nullable', 'numeric', 'min:0'],
            'item.cost' => ['required', 'numeric', 'min:0'],
            'item.sold_by' => ['required', 'string', 'in:each,weight'],
            'item.is_for_sale' => ['required', 'boolean'],
            'item.image' => ['nullable', 'string'],
            'stock.vendor_id' => ['nullable', 'integer', 'exists:vendors,id'],
            'stock.in_stock' => ['nullable', 'integer', 'min:0'],
            'stock.minimum_stock' => ['nullable', 'integer', 'min:0'],
            'track_stock' => ['required', 'boolean']
        ];
    }
}
