<?php

namespace App\Http\Requests\Purchases\Bill;

use App\Http\Requests\BaseRequest;

class MailRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => ['nullable', 'string'],
            'greeting' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'footer' => ['nullable', 'string']
        ];
    }
}