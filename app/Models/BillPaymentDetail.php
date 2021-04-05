<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'total_discounts',
        'total_taxes',
        'sub_total',
        'total',
        'amount_due',
        'over_due'
    ];

    public $timestamps = false;
}
