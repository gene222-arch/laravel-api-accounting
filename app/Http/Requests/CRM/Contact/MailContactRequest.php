<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class MailContactRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
            'subject' => ['required', 'string'],
            'body' => ['required', 'string']
        ];
    }
}
