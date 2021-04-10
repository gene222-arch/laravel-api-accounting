<?php

namespace App\Http\Requests\DoubleEntry\ChartOfAccount;

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
            'id' => ['required', 'integer', 'exists:chart_of_accounts,id'],
            'name' => ['required', 'string', 'unique:chart_of_accounts,name,' . $this->id],
            'code' => ['required', 'string', 'unique:chart_of_accounts,code,' . $this->id],
            'type' => ['required', 'string'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
