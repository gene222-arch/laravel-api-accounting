<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $table = 'company';

    protected $fillable = [
        'name',
        'email',
        'tax_number',
        'phone',
        'address',
        'logo'
    ];  
}
