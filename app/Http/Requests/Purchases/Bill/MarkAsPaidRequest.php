<?php

namespace App\Http\Requests\Purchases\Bill;

use App\Http\Requests\BaseRequest;

class MarkAsPaidRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric', 'min:0'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }
}
