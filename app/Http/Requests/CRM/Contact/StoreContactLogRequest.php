<?php

namespace App\Http\Requests\CRM\Contact;

use App\Http\Requests\BaseRequest;

class StoreContactLogRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:h:i:s'],
            'log' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ];
    }
}
