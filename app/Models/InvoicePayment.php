<?php

namespace App\Models;

use App\Traits\Sales\Invoice\InvoicePaymentsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePayment extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use InvoicePaymentsServices;

    protected $fillable = [
        'invoice_id',
        'account_id',
        'currency_id',
        'payment_method_id',
        'date',
        'amount',
        'description',
        'reference'
    ];
    
    /**
     * Define an inverse one-to-many relationship with Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
