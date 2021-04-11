<?php

namespace App\Http\Requests\Banking\Account;

use App\Http\Requests\BaseRequest;

class AccountBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'currency_id' => 'currency',
            'opening_balance' => 'opening balance',
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
