<?php

namespace App\Http\Requests\Settings\Account;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
