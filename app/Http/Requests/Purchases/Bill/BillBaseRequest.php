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
            'vendor_id.exists' => 'The selected :attribute does not exist.',
            'items.*.item_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
