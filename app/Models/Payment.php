<?php

namespace App\Models;

use App\Traits\Sales\Payment\PaymentsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PaymentsServices;

    protected $fillable = [
        'model_type',
        'model_id',
        'date',
        'amount',
        'account',
        'currency',
        'description',
        'payment_method',
        'reference'
    ];
}
