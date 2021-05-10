<?php

namespace App\Http\Requests\Sales\Revenue;

use App\Http\Requests\BaseRequest;

class UpdateStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * ? is currency necessary 
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'reference' => ['nullable', 'string'],
            'file' => ['nullable', 'string'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'income_category_id' => ['required', 'integer', 'exists:income_categories,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            // 'currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
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
            'account_id' => 'account',
            'customer_id' => 'customer',
            'income_category_id' => 'expense category',
            'payment_method_id' => 'payment method',
            'currency_id' => 'currency',
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
            'customer_id.exists' => 'The selected :attribute does not exist.',
            'income_category_id.exists' => 'The selected :attribute does not exist.',
            'payment_method_id.exists' => 'The selected :attribute does not exist.',
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
