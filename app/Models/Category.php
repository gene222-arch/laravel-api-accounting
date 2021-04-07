<?php

namespace App\Models;

use App\Traits\Item\Category\CategoriesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use CategoriesServices;

    protected $fillable = [
        'name',
        'hex_code'
    ];  

}
