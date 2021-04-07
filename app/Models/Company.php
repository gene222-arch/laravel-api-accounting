<?php

namespace App\Models;

use App\Traits\Settings\Company\CompanyServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use CompanyServices;

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
