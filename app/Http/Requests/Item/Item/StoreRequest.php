<?php

namespace App\Http\Requests\Item\Item;

use App\Http\Requests\Item\Item\ItemBaseRequest;

class StoreRequest extends ItemBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $doTrackStock = !$this->track_stock ? 'nullable' : 'required';

        return [
            'item.category_id' => ['required', 'integer', 'exists:categories,id'],
            'item.sku' => ['required', 'string', 'min:8', 'max:12', 'unique:items,sku'],
            'item.barcode' => ['required', 'string', 'min:3', 'max:12', 'unique:items,barcode'],
            'item.name' => ['required', 'string', 'unique:items,name'],
            'item.description' => ['nullable', 'string'],
            'item.price' => ['required', 'numeric', 'min:1'],
            'item.cost' => ['required', 'numeric', 'min:1'],
            'item.sold_by' => ['required', 'string', 'in:each,weight'],
            'item.is_for_sale' => ['required', 'boolean'],
            'item.image' => ['nullable', 'string'],
            'stock.vendor_id' => [$doTrackStock, 'integer', 'exists:vendors,id'],
            'stock.in_stock' => [$doTrackStock, 'integer', 'min:0'],
            'stock.minimum_stock' => [$doTrackStock, 'integer', 'min:1'],
            'track_stock' => ['required', 'boolean']
        ];
    }
}
