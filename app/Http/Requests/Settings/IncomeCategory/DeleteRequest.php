<?php

namespace App\Http\Requests\Settings\IncomeCategory;

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
            'ids.*' => ['required', 'integer',  'distinct', 'exists:income_categories,id'],
        ];
    }
}
