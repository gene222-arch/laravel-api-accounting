<?php

namespace App\Http\Requests\ImportsRequest;

use App\Http\Requests\BaseRequest;

class ImportRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' =>  ['required', 'file', 'mimetypes:text/xlsx,text/csv', 'max:2000'],
        ];
    }
}
