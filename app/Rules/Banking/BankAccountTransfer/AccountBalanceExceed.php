<?php

namespace App\Rules\Banking\BankAccountTransfer;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class AccountBalanceExceed implements Rule
{
    public int $fromAccountId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $fromAccountId)
    {
        $this->fromAccountId = $fromAccountId;
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
        return Account::find($this->fromAccountId)->balance >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The amount transferred exceeds the account\'s sender current balance.';
    }
}
