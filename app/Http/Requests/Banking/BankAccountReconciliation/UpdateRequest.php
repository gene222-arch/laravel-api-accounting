<?php

namespace App\Http\Requests\Banking\BankAccountReconciliation;

use App\Http\Requests\BaseRequest;
use App\Rules\Banking\BankAccountReconciliation\Reconcile;

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
            'id' => ['required', 'integer', 'exists:bank_account_reconciliations,id'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'startedAt' => ['required', 'date'],
            'endedAt' => ['required', 'date'],
            'closingBalance' => ['required', 'numeric', 'min:0'],
            'clearedAmount' => ['required', 'numeric'],
            'difference' => ['required', 'numeric', new Reconcile($this->reconciled)],
            'reconciled' => ['required', 'boolean']
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
            'accountId' => 'account id',
            'startedAt' => 'started at',
            'endedAt' => 'ended at',
            'closingBalance' => 'closing balance',
            'clearedAmount' => 'cleared amount'
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
            'accountId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
