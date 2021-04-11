<?php

namespace App\Http\Requests\DoubleEntry\JournalEntry;

use App\Http\Requests\BaseRequest;

class UpdateStoreRequest extends BaseRequest
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
            'items.*' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'integer', 'distinct', 'exists:items,id']
        ];
    }

    /**
     * Customize the error message
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'items.*.item_id.exists' => 'The selected item does not exists'
        ];
    }
}
