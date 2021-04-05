<?php

namespace App\Http\Requests\Item\Category;

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
            'id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'unique:categories,name,' . $this->id],
            'hexCode' => ['required', 'string', 'min:4', 'max:7', 'unique:categories,hex_code,' . $this->id],
            'enabled' => ['required', 'boolean']
        ];
    }
}
