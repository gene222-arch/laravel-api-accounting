<?php

namespace App\Http\Requests\CRM\Company;

use App\Http\Requests\BaseRequest;

class StoreCompanyNoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note' => ['required', 'string']
        ];
    }
}
