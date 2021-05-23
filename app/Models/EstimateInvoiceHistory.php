<?php

namespace App\Models;

use Carbon\Carbon;
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
    
    /**
     * getCreatedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('Y M, d');
    }
}
