<?php

namespace App\Http\Requests\AccessRight;

use App\Http\Requests\BaseRequest;

class DestroyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roleIds.*' => ['required', 'integer', 'distinct', 'exists:roles,id']
        ];
    }
}
