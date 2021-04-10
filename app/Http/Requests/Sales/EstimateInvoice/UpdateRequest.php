<?php

namespace App\Http\Requests\Sales\EstimateInvoice;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:estimate_invoices,id'],
            'customerId' => ['required', 'integer', 'exists:customers,id'],
            'estimateNumber' => ['required', 'string', 'unique:estimate_invoices,estimate_number'],
            'estimatedAt' => ['required', 'date'],
            'expiredAt' => ['required', 'date'],
            'enableReminder' => ['required', 'boolean'],
            'items.*' => ['required', 'array', 'min:1'],
            'paymentDetail.total_discounts' => ['required', 'numeric', 'min:0'],
            'paymentDetail.total_taxes' => ['required', 'numeric', 'min:0'],
            'paymentDetail.sub_total' => ['required', 'numeric', 'min:0'],
            'paymentDetail.total' => ['required', 'numeric', 'min:0']
        ];
    }

    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'customerId' => 'customer id',
            'estimateInvoiceNumber' => 'estimate invoice number',
            'estimatedAt' => 'estimated date',
            'expiredAt' => 'expired date',
            'paymentDetail.total_discounts' => 'discounts',
            'paymentDetail.total_taxes' => 'taxes',
            'paymentDetail.sub_total' => 'sub total',
            'paymentDetail.total' => 'total',
        ];
    }
}
