<?php

namespace App\Http\Requests\Item\Item;

use App\Http\Requests\BaseRequest;

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
            'item.categoryId' => ['required', 'integer', 'exists:categories,id'],
            'item.sku' => ['required', 'string', 'min:8', 'max:12', 'unique:items,sku'],
            'item.barcode' => ['required', 'string', 'min:3', 'max:12', 'unique:items,barcode'],
            'item.name' => ['required', 'string', 'unique:items,name'],
            'item.description' => ['nullable', 'string'],
            'item.price' => ['nullable', 'numeric', 'min:0'],
            'item.cost' => ['required', 'numeric', 'min:0'],
            'item.soldBy' => ['required', 'string', 'in:each,weight'],
            'item.isForSale' => ['required', 'boolean'],
            'item.image' => ['nullable', 'string'],
            'item.taxes.*' => ['nullable', 'integer', 'distinct', 'exists:taxes,id'],

            'trackStock' => ['required', 'boolean'],

            'stock.supplierId' => ['nullable', 'integer', 'exists:suppliers,id'],
            'stock.inStock' => ['nullable', 'integer', 'min:0'],
            'stock.minimumStock' => ['nullable', 'integer', 'min:0'],
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
            'item.categoryId' => 'category id',
            'item.sku' => 'sku',
            'item.barcode' => 'barcode',
            'item.name' => 'name',
            'item.description' => 'description',
            'item.price' => 'price',
            'item.cost' => 'cost',
            'item.soldBy' => 'sold by',
            'item.isForSale' => 'is for sale',
            'item.image' => 'image',
            'item.taxes' => 'taxes',

            'stock.supplierId' => 'supplier id',
            'stock.inStock' => 'in stock',
            'stock.minimumStock' => 'minimum stock',
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
            'item.categoryId.exists' => 'The selected :attribute does not exist.',
            'item.taxes.exists' => 'The selected :attribute does not exist.',
            'stock.supplierId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
