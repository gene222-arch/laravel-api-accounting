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
            'code' => ['required', 'string', 'unique:currencies,code,' . $this->id]
        ];
    }
}
