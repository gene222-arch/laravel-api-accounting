<?php

namespace App\Http\Requests\Sales\EstimateInvoice;

use App\Http\Requests\BaseRequest;

class EstimateInvoiceBaseRequest extends BaseRequest
{

    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'customer_id' => 'customer id',
            'currency_id' => 'currency id',
            'income_category_id' => 'income category id',
            'estimate_number' => 'estimate invoice number',
            'estimated_at' => 'estimated date',
            'expired_at' => 'expired date',
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
