<?php

namespace App\Traits\Auth\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

trait UsersServices
{
    
    /**
     * Get latest records of users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers (): Collection
    {
        return User::latest()
            ->get([
                'id', 
                ...(new User())->getFillable()
            ]);
    }
    
    /**
     * Get a record of user via id
     *
     * @param  int $id
     * @return User|null
     */
    public function getUserById (int $id): User|null
    {
        return User::select(
            'id',
            ...(new User())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of user with roles
     *
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $email
     * @param  string $password
     * @param  integer $roleId
     * @return mixed
     */
    public function createUserWithRoles (string $firstName, string $lastName, string $email, string $password, int $roleId): mixed
    {
        try {
            DB::transaction(function () use ($firstName, $lastName, $email, $password, $roleId)
            {
                $user = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password' => Hash::make($password)
                ]);

                $user->assignRole($roleId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
    
    /**
     * Update an existing record of user via id
     *
     * @param  integer $id
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $email
     * @param  string|null $password
     * @param  integer $roleId
     * @param  bool $updatePassword
     * @return mixed
     */
    public function updateUserWithRolesById (int $id, string $firstName, string $lastName, string $email, ?string $password, int $roleId, bool $updatePassword): mixed
    {
        try {
            DB::transaction(function () use ($id, $firstName, $lastName, $email, $password, $roleId, $updatePassword)
            {
                $user = User::find($id);

                $user
                    ->update([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'password' => !$updatePassword ? DB::raw('password') : $password
                    ]);

                $user->syncRoles($roleId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Update an existing record of user via email
     *
     * @param  string $emailToFind
     * @param  string $firstName
     * @param  string $lastName
     * @param  string $email
     * @param  string|null $password
     * @param  integer $roleId
     * @param  bool $updatePassword
     * @return mixed
     */
    public function updateUserWithRolesByEmail (string $emailToFind, string $firstName, string $lastName, string $email, ?string $password, int $roleId, bool $updatePassword = false): mixed
    {
        try {
            DB::transaction(function () use ($emailToFind, $firstName, $lastName, $email, $password, $roleId, $updatePassword)
            {
                $user = User::where('email', $emailToFind)->first();

                $user
                    ->update([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'password' => !$updatePassword ? DB::raw('password') : $password
                    ]);

                $user->syncRoles($roleId);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Delete one or multiple records of users
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteUsers (array $ids): bool
    {
        return User::whereIn('id', $ids)->delete();
    }
}