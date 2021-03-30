<?php

namespace App\Traits\Auth;

trait AuthServices
{
    public function authPermissionViaRoles ()
    {
        return auth()->user()->getPermissionsViaRoles()->map->name;
    }
}