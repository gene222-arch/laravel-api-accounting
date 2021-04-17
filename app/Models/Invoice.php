<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sales\Invoice\InvoicesServices;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use InvoicesServices;

    protected $fillable = [
        'customer_id',
        'currency_id',
        'income_category_id',
        'invoice_number',
        'order_no',
        'date',
        'due_date',
        'status',
        'recurring'
    ];
    
    /**
     * Define a many-to-many relationship with Currency class
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Define a many-to-many relationship with Customer class
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Define a many-to-many relationship with IncomeCategory class
     *
     * @return BelongsTo
     */
    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    /**
     * Define a many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items(): belongsToMany
    {
        return $this->belongsToMany(Item::class, 'invoice_details')
            ->withPivot([
                'discount_id',
                'tax_id',
                'item',
                'price',
                'quantity',
                'amount',
                'discount',
                'tax'
            ])
            ->withTimestamps();
    }

    /**
     * Define a one-to-one relationship with InvoicePaymentDetail class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentDetail(): HasOne
    {
        return $this->hasOne(InvoicePaymentDetail::class);
    }

    /**
     * Define many-to-one relationship with InvoiceHistory class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(InvoiceHistory::class);
    }
}
