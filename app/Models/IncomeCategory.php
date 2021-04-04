<?php

namespace App\Models;

use App\Traits\Sttings\IncomeCategory\IncomeCategoriesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
