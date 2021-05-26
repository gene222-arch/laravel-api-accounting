<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class StoreContactScheduleRequest extends BaseRequest
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
            'name' => ['required', 'string', 'unique:contact_schedules,name'],
            'log' => ['required', 'string'],
            'started_at' => ['required', 'date'],
            'updated_at' => ['required', 'date'],
            'time_started' => ['required', 'date_format:h:i:s'],
            'time_ended' => ['required', 'date_format:h:i:s'],
            'description' => ['nullable', 'string']
        ];
    }
}
