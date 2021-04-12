<?php

namespace App\Http\Requests\HumanResource\Payroll\Payroll;

use App\Http\Requests\BaseRequest;

class PayrollBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'account_id' => 'account id',
            'vendor_id' => 'vendor id',
            'expense_category_id' => 'expense category id',
            'payment_method_id' => 'payment method id',
            'from_date' => 'from date',
            'to_date' => 'to date',
            'payment_date' => 'payment date',
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
            'payment_method_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
