<?php

namespace App\Traits\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait AccountServices
{
    
    /**
     * Update's the user 
     *
     * @param  int $userId
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $email
     * @param  string $password
     * @return void
     */
    public function updateAccount (int $userId, string $firstName, string $lastName, string $email, string $password)
    {
        return User::where('id', $userId)
            ->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
    }

        
    /**
     * Verify if the user's password match the hashed password
     *
     * @param  int $userId
     * @param  string $password
     * @return boolean
     */
    public function verifyAccountViaPassword (int $userId, string $password): bool
    {
        return Hash::check($password, User::find($userId)->password);
    }

}