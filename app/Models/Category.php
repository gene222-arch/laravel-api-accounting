<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'name',
        'hex_code'
    ];  

}
