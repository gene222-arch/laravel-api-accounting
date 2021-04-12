<?php

namespace App\Http\Requests\Purchases\Bill;

use App\Http\Requests\Purchases\Bill\BillBaseRequest;

class UpdateRequest extends BillBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:bills,id'],
            'vendor_id' => ['required', 'integer', 'exists:vendors,id'],
            'bill_number' => ['required', 'string', 'unique:bills,bill_number,' . $this->id],
            'order_no' => ['required', 'integer', 'unique:bills,order_no,' . $this->id],
            'date' => ['required', 'string'],
            'due_date' => ['required', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id'],
            'payment_details.total_discounts' => ['required', 'numeric', 'min:0'],
            'payment_details.total_taxes' => ['required', 'numeric', 'min:0'],
            'payment_details.sub_total' => ['required', 'numeric', 'min:0'],
            'payment_details.total' => ['required', 'numeric', 'min:0'],
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
            'vendor_id' => 'vendor id',
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
