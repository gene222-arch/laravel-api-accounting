<?php

namespace App\Http\Requests\Settings\Contribution;

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
            'id' => ['required', 'integer', 'exists:contributions,id'],
            'name' => ['required', 'string', 'unique:contributions,name,' . $this->id],
            'rate' => ['required', 'numeric', 'min:0'],
            'enabled' => ['required', 'boolean']
        ];
    }
}
