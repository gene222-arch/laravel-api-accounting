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
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
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
            'payment_method_id' => 'payment method id',
            'income_category_id' => 'income category id',
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
            'payment_method_id.exists' => 'The selected :attribute does not exist.',
            'income_category_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
