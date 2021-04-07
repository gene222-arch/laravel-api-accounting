<?php

namespace App\Http\Requests\Settings\Company;

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
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'taxNumber' => ['required', 'string', 'min:9', 'max:11'],
            'phone' => ['required', 'string', 'min:11', 'max:15'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'string']
        ];
    }
}
