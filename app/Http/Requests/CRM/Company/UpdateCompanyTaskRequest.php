<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class UpdateCompanyTaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_id' => ['required', 'integer', 'exists:crm_company_tasks,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'unique:crm_company_tasks,name,' . $this->task_id],
            'started_at' => ['required', 'date'],
            'time_started' => ['required', 'date_format:h:i:s'],
            'description' => ['nullable', 'string']
        ];
    }
}
