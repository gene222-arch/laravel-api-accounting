<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'exists:contacts,id'],
            'name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:contacts,email,' . $this->id],
            'phone' => ['required', 'string', 'unique:contacts,phone,' . $this->id],
            'stage' => ['required', 'string'],
            'mobile' => ['required', 'string', 'unique:contacts,mobile,' . $this->id],
            'website' => ['required', 'string'],
            'fax_number' => ['required', 'string', 'unique:contacts,fax_number,' . $this->id],
            'source' => ['required', 'string'],
            'address' => ['required', 'string'],
            'born_at' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
