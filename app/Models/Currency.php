<?php

namespace App\Models;

use App\Traits\Settings\Currency\CurrenciesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use CurrenciesServices;

    protected $fillable = [
        'name',
        'code'
    ];
}
