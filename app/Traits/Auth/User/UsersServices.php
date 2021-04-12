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
     * @param  string $first_name
     * @param  string $last_name
     * @param  string $email
     * @param  string $password
     * @param  integer $role_id
     * @return mixed
     */
    public function createUserWithRoles (string $first_name, string $last_name, string $email, string $password, int $role_id): mixed
    {
        try {
            DB::transaction(function () use ($first_name, $last_name, $email, $password, $role_id)
            {
                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => Hash::make($password)
                ]);

                $user->assignRole($role_id);
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
     * @param  string $first_name
     * @param  string $last_name
     * @param  string $email
     * @param  string|null $password
     * @param  integer $role_id
     * @param  bool $updatePassword
     * @return mixed
     */
    public function updateUserWithRolesById (int $id, string $first_name, string $last_name, string $email, ?string $password, int $role_id, bool $updatePassword): mixed
    {
        try {
            DB::transaction(function () use ($id, $first_name, $last_name, $email, $password, $role_id, $updatePassword)
            {
                $user = User::find($id);

                $user->update([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => !$updatePassword ? DB::raw('password') : $password
                ]);

                $user->syncRoles($role_id);
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
     * @param  string $first_name
     * @param  string $last_name
     * @param  string $email
     * @param  string|null $password
     * @param  integer $role_id
     * @param  bool $updatePassword
     * @return mixed
     */
    public function updateUserWithRolesByEmail (string $emailToFind, string $first_name, string $last_name, string $email, ?string $password, int $role_id, bool $updatePassword = false): mixed
    {
        try {
            DB::transaction(function () use ($emailToFind, $first_name, $last_name, $email, $password, $role_id, $updatePassword)
            {
                $user = User::where('email', $emailToFind)->first();

                $user
                    ->update([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'password' => !$updatePassword ? DB::raw('password') : $password
                    ]);

                $user->syncRoles($role_id);
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