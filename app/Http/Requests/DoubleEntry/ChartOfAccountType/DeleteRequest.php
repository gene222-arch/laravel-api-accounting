<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccountType;

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
            'ids.*' => ['required', 'integer', 'distinct', 'exists:chart_of_account_types,id']
        ];
    }
}
