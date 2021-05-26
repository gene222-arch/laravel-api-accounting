<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class DeleteCompanyTaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_ids.*' => ['required', 'integer', 'distinct', 'exists:crm_company_tasks,id'] 
        ];
    }
}
