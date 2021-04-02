<?php

namespace App\Http\Requests\Item\Category;

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
            'name' => ['required', 'string', 'unique:categories,name'],
            'hexCode' => ['required', 'string', 'min:4', 'max:7', 'unique:categories,hex_code']
        ];
    }
}
