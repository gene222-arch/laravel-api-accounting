<?php

namespace App\Models;

use App\Traits\Item\Discount\DiscountsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use DiscountsServices;

    protected $fillable = [
        'name',
        'rate'
    ];
}
