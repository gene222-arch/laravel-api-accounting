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
            'date' => ['required', 'date'],
            'reference' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'details' => ['required', 'array'],
            'details.*.chart_of_account_id' => ['required', 'integer', 'exists:chart_of_accounts,id']
        ];
    }
    
    /**
     * Rename attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'details.*.chart_of_account_id' => 'chart of account'
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
            'details.*.chart_of_account_id' => 'The selected item does not exists'
        ];
    }
}
