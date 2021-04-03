<?php

namespace App\Traits\AccessRight;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

trait AccessRightServices
{

    /**
     * Create a new role and assign a list of permissions
     * 
     * @param string $role
     * @param array $permissions
     * @return mixed
     */
    public function createAccessRight (string $role, array $permissions): mixed
    {
        try {

            DB::transaction(function () use ($role, $permissions) 
            {
                $role = Role::create([
                    'name' => $role,
                    'guard_name' => 'api',
                    'updated_at' => null
                ]);
        
                $role->givePermissionTo(...$permissions);
            });

            return true;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update an existing access right
     *
     * @param integer $id
     * @param string $role
     * @param array $permissions
     * @return mixed
     */
    public function updateAccessRight (int $id, string $role, array $permissions): mixed
    {
        try {
            DB::transaction(function () use ($id, $role, $permissions) 
            {
                $findRole = Role::find($id);

                $findRole->update([
                    'name' => $role
                ]);

                $findRole->syncPermissions($permissions);
            });

            return true;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    
    /**
     * Delete one or multiple roles with it's associated permissions
     *
     * @param  array $ids
     * @return void
     */
    public function deleteAccessRights (array $ids)
    {
       return Role::whereIn('id', $ids)->delete();
    }

}