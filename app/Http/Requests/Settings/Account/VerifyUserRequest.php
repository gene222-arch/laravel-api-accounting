<?php

namespace App\Http\Requests\Settings\Account;

use App\Http\Requests\BaseRequest;

class VerifyUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => ['required', 'integer', 'exists:users,id'],
            'password' => ['required', 'string']
        ];
    }
}
