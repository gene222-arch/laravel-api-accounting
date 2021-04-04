<?php

namespace App\Models;

use App\Traits\Settings\PaymentMethod\PaymentMethodsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PaymentMethodsServices;

    protected $fillable = [
        'name'
    ];
}
