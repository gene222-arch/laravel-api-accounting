<?php

namespace App\Http\Requests\Item\Item;

use App\Http\Requests\BaseRequest;

class ItemBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'item.category_id' => 'category id',
            'item.sku' => 'sku',
            'item.barcode' => 'barcode',
            'item.name' => 'name',
            'item.description' => 'description',
            'item.price' => 'price',
            'item.cost' => 'cost',
            'item.sold_by' => 'sold by',
            'item.is_for_sale' => 'is for sale',
            'item.image' => 'image',
            'stock.vendor_id' => 'supplier id',
            'stock.in_stock' => 'in stock',
            'stock.minimum_stock' => 'minimum stock',
            'taxes.*' => 'taxes',
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'item.category_id.exists' => 'The selected :attribute does not exist.',
            'taxes.*.exists' => 'The selected :attribute does not exist.',
            'stock.vendor_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
