<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{

    protected $fillable = [
        'name',
        'guard_name',
        'enabled'
    ];

}
