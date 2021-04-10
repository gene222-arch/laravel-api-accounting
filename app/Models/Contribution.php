<?php

namespace App\Models;

use App\Traits\Settings\Contribution\ContributionsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use ContributionsServices;

    protected $fillable = [
        'name',
        'rate',
        'enabled'
    ];
    
}
