<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class UpdateContacteNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_id' => ['required', 'integer', 'exists:contact_notes,id'],
            'note' => ['required', 'string']
        ];
    }
}
