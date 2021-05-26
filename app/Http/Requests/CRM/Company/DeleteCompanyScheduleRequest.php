<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class DeleteCompanyScheduleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedule_ids.*' => ['required', 'integer', 'exists:crm_company_schedules,id']
        ];
    }
}
