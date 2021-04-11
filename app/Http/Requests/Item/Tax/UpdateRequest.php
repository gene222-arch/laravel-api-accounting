<?php

namespace App\Http\Requests\Item\Tax;

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
            'id' => ['required', 'integer', 'exists:taxes,id'],
            'name' => ['required', 'string', 'unique:taxes,name,' . $this->id],
            'rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'string', 'in:Normal,Compound,Fixed,Inclusive,Withholding'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
