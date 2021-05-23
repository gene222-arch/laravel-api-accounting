<?php

namespace App\Http\Requests\Sales\EstimateInvoice;

use App\Http\Requests\Sales\EstimateInvoice\EstimateInvoiceBaseRequest;

class ConvertToInvoiceRequest extends EstimateInvoiceBaseRequest
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
            'invoice_number' => ['required', 'string', 'unique:invoices,invoice_number'],
            'order_no' => ['required', 'integer', 'unique:invoices,order_no'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date']
        ];
    }
}
