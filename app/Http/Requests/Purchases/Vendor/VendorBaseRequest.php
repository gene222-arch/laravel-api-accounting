<?php

namespace App\Http\Requests\Purchases\Vendor;

use App\Http\Requests\BaseRequest;

class VendorBaseRequest extends BaseRequest
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
            'tax_number' => 'tax number',
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
            'tax_number.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
