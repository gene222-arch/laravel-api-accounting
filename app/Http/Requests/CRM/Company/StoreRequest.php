<?php

namespace App\Http\Requests\CRM\Company;

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
            'name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:crm_companies,email'],
            'phone' => ['required', 'string', 'unique:crm_companies,phone'],
            'stage' => ['required', 'string'],
            'mobile' => ['required', 'string', 'unique:crm_companies,mobile'],
            'website' => ['required', 'string'],
            'fax_number' => ['required', 'string', 'unique:crm_companies,fax_number'],
            'source' => ['required', 'string'],
            'address' => ['required', 'string'],
            'born_at' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
