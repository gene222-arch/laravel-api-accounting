<?php

namespace App\Http\Requests\AccessRight;

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
            'role' => ['required', 'string', 'unique:roles,name'],
            'permissions.*' => ['required', 'distinct', 'exists:permissions,name']
        ];
    }
}
