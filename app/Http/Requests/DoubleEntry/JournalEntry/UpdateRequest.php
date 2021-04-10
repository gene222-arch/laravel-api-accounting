<?php

namespace App\Http\Requests\DoubleEntry\JournalEntry;

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
            'id' => ['required', 'integer', 'exists:journal_entries,id'],
            'date' => ['required', 'string'],
            'reference' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'items.*' => ['required', 'array', 'min:1']
        ];
    }
}
