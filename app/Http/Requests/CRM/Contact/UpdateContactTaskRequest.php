<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class UpdateContactTaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_id' => ['required', 'integer', 'exists:contact_tasks,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'unique:contact_tasks,name,' . $this->task_id],
            'started_at' => ['required', 'date'],
            'time_started' => ['required', 'date_format:h:i:s'],
            'description' => ['nullable', 'string']
        ];
    }
}
