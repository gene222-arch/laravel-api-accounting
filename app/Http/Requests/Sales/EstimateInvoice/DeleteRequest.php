<?php

namespace App\Http\Requests\Sales\EstimateInvoice;

use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids.*' => ['required', 'integer', 'distinct', 'exists:estimate_invoices,id']
        ];
    }
}
