<?php

namespace App\Http\Requests\DoubleEntry\JournalEntry;

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
            'date' => ['required', 'string'],
            'reference' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'items.*' => ['required', 'array', 'min:1']
        ];
    }
}
