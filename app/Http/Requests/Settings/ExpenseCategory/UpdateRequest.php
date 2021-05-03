<?php

namespace App\Http\Requests\Settings\ExpenseCategory;

use App\Http\Requests\Settings\ExpenseCategory\ExpenseCategoryBaseRequest;

class UpdateRequest extends ExpenseCategoryBaseRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:expense_categories,id'],
            'name' => ['required', 'string', 'unique:expense_categories,name,' . $this->id],
            'hex_code' => ['required', 'string', 'min:4', 'max:7', 'unique:expense_categories,hex_code,' . $this->id]
        ];
    }

}
