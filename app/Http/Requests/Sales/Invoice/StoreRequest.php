<?php

namespace App\Http\Requests\Sales\Invoice;

use App\Http\Requests\Sales\Invoice\InvoiceBaseRequest;

class StoreRequest extends InvoiceBaseRequest
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
            'invoice_number' => ['required', 'string', 'unique:invoices,invoice_number'],
            'order_no' => ['required', 'integer', 'unique:invoices,order_no'],
            'date' => ['required', 'string'],
            'due_date' => ['required', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'items.*.tax_id' => ['nullable', 'integer', 'distinct', 'exists:taxes,id'],
            'payment_details.total_discounts' => ['required', 'numeric', 'min:0'],
            'payment_details.total_taxes' => ['required', 'numeric', 'min:0'],
            'payment_details.sub_total' => ['required', 'numeric', 'min:0'],
            'payment_details.total' => ['required', 'numeric', 'min:0'],
        ];
    }
}
