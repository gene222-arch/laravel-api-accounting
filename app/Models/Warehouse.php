<?php

namespace App\Models;

use App\Traits\InventoryManagement\Warehouse\WarehousesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use WarehousesServices;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'default_warehouse',
        'enabled'
    ];
}
