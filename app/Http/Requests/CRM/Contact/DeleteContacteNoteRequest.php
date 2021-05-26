<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class DeleteContacteNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_ids.*' => ['required', 'integer', 'distinct', 'exists:contact_notes,id'] 
        ];
    }
}
