<?php

namespace App\Http\Requests\Settings\Currency;

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
            'id' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string', 'unique:currencies,name,' . $this->id],
            'code' => ['required', 'string', 'min:3', 'max:3', 'unique:currencies,code,' . $this->id],
            'rate' => ['required', 'numeric', 'min:1'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
