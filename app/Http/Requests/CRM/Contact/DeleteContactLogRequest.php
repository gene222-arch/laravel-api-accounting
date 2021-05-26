<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class DeleteContactLogRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'log_ids.*' => ['required', 'integer', 'distinct', 'exists:contact_logs,id']
        ];
    }
}
