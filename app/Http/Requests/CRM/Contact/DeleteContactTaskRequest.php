<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class DeleteContactTaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_ids.*' => ['required', 'integer', 'distinct', 'exists:contact_tasks,id'] 
        ];
    }
}
