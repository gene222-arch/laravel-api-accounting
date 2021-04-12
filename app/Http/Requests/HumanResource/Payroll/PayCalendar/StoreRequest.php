<?php

namespace App\Http\Requests\HumanResource\Payroll\PayCalendar;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'unique:pay_calendars,name'],
            'type' => ['required', 'string', 'in:Weekly,Bi-weekly,Semi-monthly,Monthly'],
            'employee_ids.*' => ['required', 'integer', 'distinct', 'exists:employees,id']
        ];
    }
}
