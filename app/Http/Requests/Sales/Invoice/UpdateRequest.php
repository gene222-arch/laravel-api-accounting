<?php

namespace App\Http\Requests\Sales\Invoice;

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
            'id' => ['required', 'integer', 'exists:invoices,id'],
            'customerId' => ['required', 'integer', 'exists:customers,id'],
            'invoiceNumber' => ['required', 'string', 'unique:invoices,invoice_number,' . $this->id],
            'orderNo' => ['required', 'integer', 'unique:invoices,order_no,' . $this->id],
            'date' => ['required', 'string'],
            'dueDate' => ['required', 'string'],
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'paymentDetails.total_discounts' => ['required', 'numeric', 'min:0'],
            'paymentDetails.total_taxes' => ['required', 'numeric', 'min:0'],
            'paymentDetails.sub_total' => ['required', 'numeric', 'min:0'],
            'paymentDetails.total' => ['required', 'numeric', 'min:0'],
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
            'invoiceNumber' => 'invoice number',
            'orderNo' => 'order number',
            'dueDate' => 'due date',
            'items.*.item_id' => 'item',
            'paymentDetails.total_discounts' => 'discounts',
            'paymentDetails.total_taxes' => 'taxes',
            'paymentDetails.sub_total' => 'sub total',
            'paymentDetails.total' => 'total',
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
            'customerId.exists' => 'The selected :attribute does not exist.',
            'items.*.item_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
