<?php

namespace App\Models;

use App\Traits\Sales\Customer\CustomersServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    /** Libraries or Built-in */
    use HasFactory, Notifiable;

    /** Custom */
    use CustomersServices;

    protected $fillable = [
        'name',
        'email',
        'tax_number',
        'currency',
        'phone',
        'website',
        'address',
        'reference'
    ];
}
