<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateInvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_invoice_id',
        'item_id',
        'discount_id',
        'item',
        'price',
        'quantity',
        'amount',
        'discount',
        'tax'
    ];

}
