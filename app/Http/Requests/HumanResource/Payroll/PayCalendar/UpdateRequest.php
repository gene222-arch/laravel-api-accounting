<?php

namespace App\Http\Requests\HumanResource\Payroll\PayCalendar;

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
            'id' => ['required', 'integer', 'exists:pay_calendars,id'],
            'name' => ['required', 'string', 'unique:pay_calendars,name,' . $this->id ],
            'type' => ['required', 'string', 'in:Weekly,Bi-weekly,Semi-monthly,Monthly'],
            'employeeIds.*' => ['required', 'integer', 'distinct', 'exists:employees,id']
        ];
    }
}
