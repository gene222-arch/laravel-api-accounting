<?php

namespace App\Http\Requests\Sales\Invoice;

use App\Http\Requests\BaseRequest;

class PaymentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:invoices,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'account' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'paymentMethod' => ['required', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }

    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'paymentMethod' => 'payment method',
        ];
    }
}
