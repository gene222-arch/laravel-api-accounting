<?php

namespace App\Http\Requests\Sales\Revenue;

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
            'id' => ['required', 'integer', 'exists:revenues,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'reference' => ['nullable', 'string'],
            'file' => ['nullable', 'string'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'customerId' => ['required', 'integer', 'exists:customers,id'],
            'incomeCategoryId' => ['required', 'integer', 'exists:income_categories,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'invoiceId' => ['required', 'integer', 'exists:invoices,id'],
        ];
    }
}
