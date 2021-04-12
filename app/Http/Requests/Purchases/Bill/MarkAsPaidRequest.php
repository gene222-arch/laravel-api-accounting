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
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
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
            'account_id' => 'account id',
            'currency_id' => 'currency id',
            'payment_method_id' => 'payment method id',
            'expense_category_id' => 'expense category id',
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
            'account_id.exists' => 'The selected :attribute does not exist.',
            'currency_id.exists' => 'The selected :attribute does not exist.',
            'payment_method_id.exists' => 'The selected :attribute does not exist.',
            'expense_category_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
