<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class UpdateCompanyNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note_id' => ['required', 'integer', 'exists:crm_company_notes,id'],
            'note' => ['required', 'string']
        ];
    }
}
