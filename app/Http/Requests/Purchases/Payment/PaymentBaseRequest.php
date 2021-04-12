<?php

namespace App\Http\Requests\Purchases\Payment;

use App\Http\Requests\BaseRequest;

class PaymentBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'account_id' => 'account',
            'vendor_id' => 'vendor',
            'expense_category_id' => 'expense category',
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
            'vendor_id.exists' => 'The selected :attribute does not exist.',
            'expense_category_id.exists' => 'The selected :attribute does not exist.',
            'payment_method_id.exists' => 'The selected :attribute does not exist.',
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
