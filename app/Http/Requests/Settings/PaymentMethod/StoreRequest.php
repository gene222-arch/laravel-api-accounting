<?php

namespace App\Http\Requests\Settings\PaymentMethod;

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
            'name' => ['required', 'string', 'unique:payment_methods,name'],
        ];
    }
}
