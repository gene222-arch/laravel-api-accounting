<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class MailCompanyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'crm_company_id' => ['required', 'integer', 'exists:crm_companies,id'],
            'subject' => ['required', 'string'],
            'body' => ['required', 'string']
        ];
    }
}
