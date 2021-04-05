<?php

namespace App\Http\Requests\Item\Discount;

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
            'id' => ['required', 'integer', 'exists:discounts,id'],
            'name' => ['required', 'string', 'unique:discounts,name,' . $this->id],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
