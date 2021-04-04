<?php

namespace App\Http\Requests\Settings\IncomeCategory;

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
            'name' => ['required', 'string', 'unique:income_categories,name'],
            'hexCode' => ['required', 'string', 'min:7', 'max:7', 'unique:income_categories,hex_code']
        ];
    }
}
