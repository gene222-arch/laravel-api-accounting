<?php

namespace App\Http\Requests\Settings\Contribution;

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
            'name' => ['required', 'string', 'unique:contributions,name'],
            'rate' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
