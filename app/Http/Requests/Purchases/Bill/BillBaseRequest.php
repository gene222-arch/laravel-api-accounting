<?php

namespace App\Http\Requests\Purchases\Bill;

use App\Http\Requests\BaseRequest;

class BillBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'currency_id' => 'currency',
            'expense_category_id' => 'expense category',
            'vendor_id' => 'vendor',
            'bill_number' => 'bill number',
            'order_no' => 'order number',
            'due_date' => 'due date',
            'items.*.item_id' => 'item',
            'payment_details.total_discounts' => 'discounts',
            'payment_details.total_taxes' => 'taxes',
            'payment_details.sub_total' => 'sub total',
            'payment_details.total' => 'total',
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
            'currency_id.exists' => 'The selected :attribute does not exist.',
            'expense_category_id.exists' => 'The selected :attribute does not exist.',
            'vendor_id.exists' => 'The selected :attribute does not exist.',
            'items.*.item_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
