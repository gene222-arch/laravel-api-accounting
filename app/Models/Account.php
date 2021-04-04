<?php

namespace App\Models;

use App\Traits\Banking\Account\AccountsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use AccountsServices;

    protected $fillable = [
        'name',
        'number',
        'currency',
        'opening_balance'
    ];
}
