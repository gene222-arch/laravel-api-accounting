<?php

namespace App\Rules\Banking\BankAccountReconciliation;

use Illuminate\Contracts\Validation\Rule;

class Reconcile implements Rule
{
    public string $status;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
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
        $shouldReconcile = false;

        if ($this->status === 'Reconciled' && empty($value))
        {
            $shouldReconcile = true;
        }
        else 
        {
            $shouldReconcile = false;
        }

        if ($this->status === 'Unreconciled') 
        {
            $shouldReconcile = true;
        };
        
        return $shouldReconcile;
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
