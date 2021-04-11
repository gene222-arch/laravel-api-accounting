<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'enabled'
    ];
}
