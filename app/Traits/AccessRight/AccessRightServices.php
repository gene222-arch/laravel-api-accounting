<?php

namespace App\Traits\AccessRight;

use Illuminate\Support\Facades\DB;
use App\Models\Role;

trait AccessRightServices
{

    /**
     * Create a new role and assign a list of permissions
     * 
     * @param string $role
     * @param array $permissions
     * @param bool $enabled
     * @return mixed
     */
    public function createAccessRight (string $role, array $permissions, bool $enabled): mixed
    {
        try {
            DB::transaction(function () use ($role, $permissions, $enabled) 
            {
                $role = Role::create([
                    'name' => $role,
                    'guard_name' => 'api',
                    'enabled' => $enabled
                ]);
        
                $role->givePermissionTo(...$permissions);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Update an existing access right
     *
     * @param Role $role
     * @param string $role
     * @param array $permissions
     * @param bool $enabled
     * @return mixed
     */
    public function updateAccessRight (Role $role, string $role_name, array $permissions, bool $enabled): mixed
    {
        try {
            DB::transaction(function () use ($role, $role_name, $permissions, $enabled) 
            {
                $role->update([
                    'name' => $role_name,
                    'enabled' => $enabled
                ]);

                $role->syncPermissions($permissions);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

}