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
            'id' => ['required', 'integer', 'exists:items,id'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
            'sku' => ['required', 'string', 'min:8', 'max:12', 'unique:items,sku,' . $this->id],
            'barcode' => ['required', 'string', 'min:3', 'max:12', 'unique:items,barcode,' . $this->id],
            'name' => ['required', 'string', 'unique:items,name,' . $this->id],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'soldBy' => ['required', 'string', 'in:each,weight'],
            'isForSale' => ['required', 'boolean']
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
            'category_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
