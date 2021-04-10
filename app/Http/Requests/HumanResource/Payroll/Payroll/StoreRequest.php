<?php

namespace App\Http\Requests\HumanResource\Payroll\Payroll;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:payrolls,name'],
            'accountId' => ['required', 'integer', 'exists:accounts,id'],
            'expenseCategoryId' => ['required', 'integer', 'exists:expense_categories,id'],
            'paymentMethodId' => ['required', 'integer', 'exists:payment_methods,id'],
            'fromDate' => ['required', 'date'],
            'toDate' => ['required', 'date'],
            'paymentDate' => ['required', 'date'],
            'approved' => ['required', 'string'],
            'details.*' => ['required', 'array', 'min:1'],
            'taxes.*' => ['nullable', 'array', 'min:1'],
            'benefits.*' => ['nullable', 'array', 'min:1'],
            'contributions.*' => ['nullable', 'array', 'min:1'],
        ];
    }

    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'accountId' => 'account id',
            'vendorId' => 'vendor id',
            'expenseCategoryId' => 'expense category id',
            'paymentMethodId' => 'payment method id',
            'fromDate' => 'from date',
            'toDate' => 'to date',
            'paymentDate' => 'payment date',
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
            'accountId.exists' => 'The selected :attribute does not exist.',
            'vendorId.exists' => 'The selected :attribute does not exist.',
            'expenseCategoryId.exists' => 'The selected :attribute does not exist.',
            'paymentMethodId.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
