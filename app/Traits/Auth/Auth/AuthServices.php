<?php

namespace App\Traits\Auth\Auth;

trait AuthServices
{
    public function authPermissionViaRoles ()
    {
        return auth()->user()->getPermissionsViaRoles()->map->name;
    }
}