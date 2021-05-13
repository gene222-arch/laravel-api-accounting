<?php

namespace App\Http\Requests\Banking\BankAccountReconciliation;

use App\Http\Requests\BaseRequest;
use App\Rules\Banking\BankAccountReconciliation\Reconcile;

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
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date'],
            'closing_balance' => ['required', 'numeric', 'min:0'],
            'cleared_amount' => ['required', 'numeric'],
            'difference' => ['required', 'numeric', new Reconcile($this->status)],
            'status' => ['required', 'string', 'in:Reconciled,Unreconciled']
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
            'started_at' => 'started at',
            'ended_at' => 'ended at',
            'closing_balance' => 'closing balance',
            'cleared_amount' => 'cleared amount'
        ];
    }
}
