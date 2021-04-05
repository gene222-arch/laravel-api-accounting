<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Settings\IncomeCategory\IncomeCategoriesServices;

class IncomeCategory extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use IncomeCategoriesServices;

    protected $fillable = [
        'name',
        'hex_code'
    ];  
}
