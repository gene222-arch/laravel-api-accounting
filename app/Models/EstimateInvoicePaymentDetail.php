<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateInvoicePaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id',
        'tax_id',
        'estimate_invoice_id',
        'total_discounts',
        'total_taxes',
        'sub_total',
        'total',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
