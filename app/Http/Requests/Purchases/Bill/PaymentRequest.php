<?php

namespace App\Http\Requests\Purchases\Bill;

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
            'id' => ['required', 'integer', 'exists:bills,id'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'expenseCategoryId' => ['required', 'integer', 'exists:expense_categories,id'],
            'date' => ['required', 'date'],
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
            'expenseCategoryId' => 'expense category id',
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
            'expenseCategoryId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
