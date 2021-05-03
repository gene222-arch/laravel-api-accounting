<?php

namespace App\Http\Requests\Settings\IncomeCategory;

use App\Http\Requests\Settings\IncomeCategory\IncomeCategoryBaseRequest;

class StoreRequest extends IncomeCategoryBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:income_categories,name'],
            'hex_code' => ['required', 'string', 'min:4', 'max:7', 'unique:income_categories,hex_code']
        ];
    }
}
