<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Sales\Invoice\EstimateInvoicesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\belongsToMany;

class EstimateInvoice extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use EstimateInvoicesServices;

    protected $fillable = [
        'customer_id',
        'currency_id',
        'estimate_number',
        'enable_reminder',
        'estimated_at',
        'expired_at',
        'status'
    ];

    protected $hidden = [ 
        'created_at',
        'updated_at'
    ];
    
    /**
     * getEstimatedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getEstimatedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * getExpiredAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getExpiredAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * Define a many-to-many relationship with Item class
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Define a many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items(): belongsToMany
    {
        return $this->belongsToMany(Item::class, 'estimate_invoice_details')
            ->withPivot([
                'discount_id',
                'tax_id',
                'item',
                'price',
                'quantity',
                'amount',
                'discount',
                'tax'
            ]);
    }

    /**
     * Define a one-to-many relationship with Customer class
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Define a one-to-one relationship with EstimateInvoicePaymentDetail class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentDetail(): HasOne
    {
        return $this->hasOne(EstimateInvoicePaymentDetail::class);
    }

    /**
     * Define many-to-one relationship with EstimateInvoiceHistory class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(EstimateInvoiceHistory::class);
    }
}
