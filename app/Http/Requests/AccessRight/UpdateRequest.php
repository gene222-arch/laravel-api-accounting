<?php

namespace App\Http\Requests\AccessRight;

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
            'roleId' => ['required', 'integer', 'exists:roles,id'],
            'role' => ['required', 'string', "unique:roles,name,{$this->roleId}"],
            'permissions.*' => ['required', 'distinct', 'exists:permissions,name']
        ];
    }
}
