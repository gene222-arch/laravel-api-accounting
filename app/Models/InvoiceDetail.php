<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_id',
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
