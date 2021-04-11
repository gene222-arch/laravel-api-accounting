<?php

namespace App\Http\Requests\Banking\BankAccountTransfer;

use App\Rules\Banking\BankAccountTransfer\AccountBalanceExceed;
use App\Http\Requests\BaseRequest;

class UpdateStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_account_id' => ['required', 'integer', 'exists:accounts,id'],
            'to_account_id' => ['required', 'integer', 'exists:accounts,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:0', new AccountBalanceExceed($this->from_account_id)],
            'transferred_at' => ['required', 'string'],
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
            'from_account_id' => 'from account',
            'to_account_id' => 'to account',
            'payment_method_id' => 'payment method',
            'transferred_at' => 'date of transfer'
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
            'from_account_id.exists' => 'The selected :attribute does not exist.',
            'to_account_id.exists' => 'The selected :attribute does not exist.',
            'payment_method_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
