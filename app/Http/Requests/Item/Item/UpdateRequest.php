<?php

namespace App\Http\Requests\Item\Item;

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
            'item.id' => ['required', 'integer', 'exists:items,id'],
            'item.categoryId' => ['required', 'integer', 'exists:categories,id'],
            'item.sku' => ['required', 'string', 'min:8', 'max:12', 'unique:items,sku,' . $this->item['id']],
            'item.barcode' => ['required', 'string', 'min:3', 'max:12', 'unique:items,barcode,' . $this->item['id']],
            'item.name' => ['required', 'string', 'unique:items,name,' . $this->item['id']],
            'item.description' => ['nullable', 'string'],
            'item.price' => ['nullable', 'numeric', 'min:0'],
            'item.cost' => ['required', 'numeric', 'min:0'],
            'item.soldBy' => ['required', 'string', 'in:each,weight'],
            'item.isForSale' => ['required', 'boolean'],
            'item.image' => ['nullable', 'string'],
            'item.taxes.*' => ['nullable', 'integer', 'distinct', 'exists:taxes,id'],

            'trackStock' => ['required', 'boolean'],

            'stock.supplierId' => ['nullable', 'integer', 'exists:suppliers,id'],
            'stock.warehouseId' => ['nullable', 'integer', 'exists:warehouses,id'],
            'stock.in_stock' => ['nullable', 'integer', 'min:0'],
            'stock.minimumStock' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'item.id' => 'id',
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
            'stock.warehouseId' => 'warehouse id',
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
            'item.id.exists' => 'The selected :attribute does not exist.',
            'item.categoryId.exists' => 'The selected :attribute does not exist.',
            'item.taxes' => 'The selected :attribute does not exist.',
            'stock.id.exists' => 'The selected :attribute does not exist.',
            'stock.supplierId.exists' => 'The selected :attribute does not exist.',
            'stock.warehouseId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
