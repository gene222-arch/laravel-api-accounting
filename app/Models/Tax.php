<?php

namespace App\Models;

use App\Traits\Item\TaxServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use TaxServices;


    protected $fillable = [
        'name',
        'rate',
        'type'
    ];
}
