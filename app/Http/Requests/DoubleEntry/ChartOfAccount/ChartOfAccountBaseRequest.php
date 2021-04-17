<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccount;

use App\Http\Requests\BaseRequest;

class ChartOfAccountBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * return $array
     */
    public function attributes()
    {
        return [
            'chart_of_account_type_id' => 'chart of account type',
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'chart_of_account_type_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
