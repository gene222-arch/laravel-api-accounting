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
            'currencyId' => ['required', 'integer', 'exists:currencies,id'],
            'invoiceNumber' => ['required', 'string', 'unique:invoices,invoice_number,' . $this->id],
            'orderNo' => ['required', 'integer', 'unique:invoices,order_no,' . $this->id],
            'date' => ['required', 'string'],
            'dueDate' => ['required', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'paymentDetail.total_discounts' => ['required', 'numeric', 'min:0'],
            'paymentDetail.total_taxes' => ['required', 'numeric', 'min:0'],
            'paymentDetail.sub_total' => ['required', 'numeric', 'min:0'],
            'paymentDetail.total' => ['required', 'numeric', 'min:0'],
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
            'currencyId' => 'currency id',
            'invoiceNumber' => 'invoice number',
            'orderNo' => 'order number',
            'dueDate' => 'due date',
            'items.*.item_id' => 'item',
            'paymentDetail.total_discounts' => 'discounts',
            'paymentDetail.total_taxes' => 'taxes',
            'paymentDetail.sub_total' => 'sub total',
            'paymentDetail.total' => 'total',
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
            'currencyId.exists' => 'The selected :attribute does not exist.',
            'items.*.item_id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
