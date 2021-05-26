<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:crm_companies,id'],
            'name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:crm_companies,email,' . $this->id],
            'phone' => ['required', 'string', 'unique:crm_companies,phone,' . $this->id],
            'stage' => ['required', 'string'],
            'mobile' => ['required', 'string', 'unique:crm_companies,mobile,' . $this->id],
            'website' => ['required', 'string'],
            'fax_number' => ['required', 'string', 'unique:crm_companies,fax_number,' . $this->id],
            'source' => ['required', 'string'],
            'address' => ['required', 'string'],
            'born_at' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
