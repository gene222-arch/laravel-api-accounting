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
            'currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
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
}
