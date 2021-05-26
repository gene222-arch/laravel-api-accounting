<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class DeleteCompanyNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_ids.*' => ['required', 'integer', 'distinct', 'exists:crm_company_notes,id'] 
        ];
    }
}
