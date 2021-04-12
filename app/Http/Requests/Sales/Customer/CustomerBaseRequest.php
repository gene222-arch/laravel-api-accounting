<?php

namespace App\Http\Requests\Sales\Customer;

use App\Http\Requests\BaseRequest;

class CustomerBaseRequest extends BaseRequest
{
    /**
     * Rename attributes
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'currency_id' => 'currency id',
            'tax_number' => 'tax number'
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
            'currency_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
