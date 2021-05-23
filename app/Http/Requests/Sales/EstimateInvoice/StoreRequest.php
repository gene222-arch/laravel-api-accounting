<?php

namespace App\Http\Requests\Sales\EstimateInvoice;

use App\Http\Requests\Sales\EstimateInvoice\EstimateInvoiceBaseRequest;

class StoreRequest extends EstimateInvoiceBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'income_category_id' => ['required', 'integer', 'exists:income_categories,id'],
            'estimate_number' => ['required', 'string', 'unique:estimate_invoices,estimate_number'],
            'estimated_at' => ['required', 'date'],
            'expired_at' => ['required', 'date'],
            'enable_reminder' => ['required', 'boolean'],
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'items.*.tax_id' => ['nullable', 'integer', 'exists:taxes,id'],
            'payment_details.tax_id' => ['required', 'numeric', 'exists:taxes,id'],
            'payment_details.discount_id' => ['required', 'numeric', 'exists:discounts,id'],
            'payment_details.total_discounts' => ['required', 'numeric', 'min:0'],
            'payment_details.total_taxes' => ['required', 'numeric', 'min:0'],
            'payment_details.sub_total' => ['required', 'numeric', 'min:0'],
            'payment_details.total' => ['required', 'numeric', 'min:0']
        ];
    }
}
