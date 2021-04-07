<?php

namespace App\Http\Requests\Sales\Revenue;

use App\Http\Requests\BaseRequest;

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
            'number' => ['nullable', 'string', 'unique:revenues,number'],
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
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
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
            'customerId' => 'customer id',
            'incomeCategoryId' => 'expense category id',
            'paymentMethodId' => 'payment method id',
            'currencyId' => 'currency id',
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
            'customerId.exists' => 'The selected :attribute does not exist.',
            'incomeCategoryId.exists' => 'The selected :attribute does not exist.',
            'paymentMethodId.exists' => 'The selected :attribute does not exist.',
            'currencyId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
