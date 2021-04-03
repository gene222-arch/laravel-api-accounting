<?php

namespace App\Http\Requests\Item\Discount;

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
            'name' => ['required', 'string', 'unique:discounts,name'],
            'rate' => ['required', 'numeric', 'min:0', 'max:100']
        ];
    }
}
