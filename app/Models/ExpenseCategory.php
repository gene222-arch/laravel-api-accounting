<?php

namespace App\Models;

use App\Traits\Settings\ExpenseCategory\ExpenseCategoriesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use ExpenseCategoriesServices;

    protected $fillable = [
        'name',
        'hex_code'
    ];  

}
