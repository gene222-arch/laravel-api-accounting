<?php

namespace App\Http\Requests\Sales\Invoice;

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
            'incomeCategoryId' => ['required', 'integer', 'exists:income_categories,id'],
            'amount' => ['required', 'numeric', 'min:0'],
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
            'accountId' => 'account id',
            'currencyId' => 'currency id',
            'paymentMethodId' => 'payment method id',
            'incomeCategoryId' => 'income category id',
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
            'currencyId.exists' => 'The selected :attribute does not exist.',
            'paymentMethodId.exists' => 'The selected :attribute does not exist.',
            'incomeCategoryId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
