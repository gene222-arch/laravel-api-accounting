<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'account_id',
        'currency_id',
        'payment_method_id',
        'date',
        'amount',
        'description',
        'reference'
    ];
}
