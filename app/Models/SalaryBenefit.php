<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryBenefit extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'enabled'
    ];
}
