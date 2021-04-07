<?php

namespace App\Http\Requests\Settings\ExpenseCategory;

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
            'name' => ['required', 'string', 'unique:expense_categories,name'],
            'hexCode' => ['required', 'string', 'min:7', 'max:7', 'unique:expense_categories,hex_code']
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
            'hexCode' => 'hex code'
        ];
    }
}
