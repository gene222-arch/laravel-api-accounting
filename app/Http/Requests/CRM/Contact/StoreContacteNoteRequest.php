<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class StoreContacteNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note' => ['required', 'string']
        ];
    }
}
