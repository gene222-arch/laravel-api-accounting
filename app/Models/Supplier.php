<?php

namespace App\Models;

use App\Traits\InventoryManagement\Supplier\SupplierServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use SupplierServices;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'main_address',
        'optional_address',
        'city',
        'zip_code',
        'country',
        'province',
        'enabled'
    ];
}
