<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class UpdateCompanyLogRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'log_id' => ['required', 'integer', 'exists:crm_company_logs,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:h:i:s'],
            'log' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ];
    }
}
