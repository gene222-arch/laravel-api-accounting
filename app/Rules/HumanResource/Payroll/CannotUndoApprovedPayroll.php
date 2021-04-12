<?php

namespace App\Rules\HumanResource\Payroll;

use App\Models\Payroll;
use Illuminate\Contracts\Validation\Rule;

class CannotUndoApprovedPayroll implements Rule
{
    public int $payrollId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $payrollId)
    {
        $this->payrollId = $payrollId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $status = Payroll::find($this->payrollId)->status;

        if ($value === 'Approved')
        {
            if ($status === 'Unapproved' || $status === 'Approved') return true;
        }
        
        else if ($status === 'Approved') return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot undo an already approved payroll.';
    }
}
