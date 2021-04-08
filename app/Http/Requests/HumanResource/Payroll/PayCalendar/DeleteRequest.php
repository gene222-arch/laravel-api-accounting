<?php

namespace App\Http\Requests\HumanResource\Payroll\PayCalendar;

use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids.*' => ['required', 'integer', 'distinct', 'exists:pay_calendars,id'],
        ];
    }
}
