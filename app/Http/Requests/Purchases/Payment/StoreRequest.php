<?php

namespace App\Http\Requests\Purchases\Payment;

use App\Http\Requests\Purchases\Payment\PaymentBaseRequest;

class StoreRequest extends PaymentBaseRequest
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
            'vendor_id' => ['required', 'integer', 'exists:vendors,id'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'reference' => ['nullable', 'string'],
            'file' => ['nullable', 'file'],
        ];
    }
}
