<?php

namespace App\Http\Requests\Settings\Account;

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
            'userId' => ['required', 'integer', 'exists:users,id'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$this->userId}"],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
