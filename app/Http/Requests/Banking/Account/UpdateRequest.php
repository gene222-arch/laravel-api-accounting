<?php

namespace App\Http\Requests\Banking\Account;

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
            'id' => ['required', 'integer', 'exists:accounts,id'],
            'name' => ['required', 'string', 'unique:accounts,name,' . $this->id],
            'number' => ['required', 'integer', 'min:5', 'unique:accounts,number,' . $this->id],
            'currency' => ['required', 'string'],
            'openingBalance' => ['required', 'numberic', 'min:0']
        ];
    }
}
