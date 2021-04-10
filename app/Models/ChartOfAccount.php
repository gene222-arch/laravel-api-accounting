<?php

namespace App\Models;

use App\Traits\DoubleEntry\ChartOfAccount\ChartOfAccountsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use ChartOfAccountsServices;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'enabled'
    ];
}
