<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateInvoicePaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_invoice_id',
        'total_discounts',
        'total_taxes',
        'sub_total',
        'total',
    ];
}
