<?php

namespace App\Http\Requests\Settings\ExpenseCategory;

use App\Http\Requests\Settings\ExpenseCategory\ExpenseCategoryBaseRequest;

class StoreRequest extends ExpenseCategoryBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:expense_categories,name'],
            'hex_code' => ['required', 'string', 'min:4', 'max:7', 'unique:expense_categories,hex_code']
        ];
    }
}
