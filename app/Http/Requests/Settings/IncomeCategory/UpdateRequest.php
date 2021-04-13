<?php

namespace App\Http\Requests\Settings\IncomeCategory;

use App\Http\Requests\Settings\IncomeCategory\IncomeCategoryBaseRequest;

class UpdateRequest extends IncomeCategoryBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:income_categories,id'],
            'name' => ['required', 'string', 'unique:income_categories,name,' . $this->id],
            'hex_code' => ['required', 'string', 'min:7', 'max:7', 'unique:income_categories,hex_code,' . $this->id]
        ];
    }
}
