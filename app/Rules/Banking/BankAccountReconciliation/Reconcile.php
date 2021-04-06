<?php

namespace App\Rules\Banking\BankAccountReconciliation;

use Illuminate\Contracts\Validation\Rule;

class Reconcile implements Rule
{
    public bool $reconciled;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(bool $reconciled)
    {
        $this->reconciled = $reconciled;
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
        if ($this->reconciled)
        {
            return empty($value);
        }
        else 
        {
            return $value;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot continue reconciliation process, amount not cleared.';
    }
}
