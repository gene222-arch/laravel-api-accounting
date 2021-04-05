<?php

namespace App\Http\Requests\Settings\PaymentMethod;

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
            'id' => ['required', 'integer', 'exists:payment_methods,id'],
            'name' => ['required', 'string', 'unique:payment_methods,name,' . $this->id],
            'enabled' => ['required', 'boolean']
        ];
    }
}
