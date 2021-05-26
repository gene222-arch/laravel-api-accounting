<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class StoreContactTaskRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'unique:contact_tasks,name'],
            'started_at' => ['required', 'date'],
            'time_started' => ['required', 'date_format:h:i:s'],
            'description' => ['nullable', 'string']
        ];
    }
}
