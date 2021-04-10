<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateInvoiceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_invoice_id',
        'status',
        'description'
    ];
}
