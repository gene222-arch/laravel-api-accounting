<?php

namespace App\Http\Requests\Settings\ExpenseCategory;

use App\Http\Requests\BaseRequest;

class ExpenseCategoryBaseRequest extends BaseRequest
{
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
