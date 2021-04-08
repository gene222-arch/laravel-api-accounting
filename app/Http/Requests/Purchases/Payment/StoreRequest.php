<?php

namespace App\Http\Requests\Purchases\Payment;

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
            'number' => ['nullable', 'string'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'vendorId' => ['required', 'integer', 'exists:vendors,id'],
            'expenseCategoryId' => ['required', 'integer', 'exists:expense_categories,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'reference' => ['nullable', 'string', 'exists:'],
            'file' => ['nullable', 'file'],
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
            'vendorId' => 'vendor id',
            'expenseCategoryId' => 'expense category id',
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
            'vendorId.exists' => 'The selected :attribute does not exist.',
            'expenseCategoryId.exists' => 'The selected :attribute does not exist.',
            'paymentMethodId.exists' => 'The selected :attribute does not exist.',
            'currencyId.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
