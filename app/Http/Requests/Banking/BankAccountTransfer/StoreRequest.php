<?php

namespace App\Http\Requests\Banking\BankAccountTransfer;

use App\Http\Requests\BaseRequest;
use App\Rules\Banking\BankAccountTransfer\AccountBalanceExceed;

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
            'fromAccountId' => ['required', 'integer', 'exists:accounts,id'],
            'toAccountId' => ['required', 'integer', 'exists:accounts,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:0', new AccountBalanceExceed($this->fromAccountId)],
            'transferredAt' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }

    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'fromAccountId' => 'from account id',
            'toAccountId' => 'to account id',
            'paymentMethodId' => 'payment method id',
            'transferredAt' => 'date'
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
            'fromAccountId.exists' => 'The selected :attribute does not exist.',
            'toAccountId.exists' => 'The selected :attribute does not exist.',
            'paymentMethodId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
