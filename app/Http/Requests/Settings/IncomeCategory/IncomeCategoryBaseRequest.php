<?php

namespace App\Http\Requests\Settings\IncomeCategory;

use App\Http\Requests\BaseRequest;

class IncomeCategoryBaseRequest extends BaseRequest
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
