<?php

namespace App\Http\Requests\Sales\Invoice;

use App\Http\Requests\BaseRequest;

class InvoiceBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'customer_id' => 'customer',
            'currency_id' => 'currency',
            'income_category_id' => 'income category',
            'invoice_number' => 'invoice number',
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
            'customer_id.exists' => 'The selected :attribute does not exist.',
            'currency_id.exists' => 'The selected :attribute does not exist.',
            'income_category_id.exists' => 'The selected :attribute does not exist.',
            'items.*.item_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
