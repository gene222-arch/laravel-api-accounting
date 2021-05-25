<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'owner' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:contacts,email'],
            'phone' => ['required', 'string', 'unique:contacts,phone'],
            'stage' => ['required', 'string'],
            'mobile' => ['required', 'string', 'unique:contacts,mobile'],
            'website' => ['required', 'string'],
            'fax_number' => ['required', 'string', 'unique:contacts,fax_number'],
            'source' => ['required', 'string'],
            'address' => ['required', 'string'],
            'born_at' => ['required', 'string']
        ];
    }
}
