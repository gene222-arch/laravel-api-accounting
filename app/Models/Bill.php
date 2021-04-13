<?php

namespace App\Models;

use App\Models\Currency;
use App\Models\Vendor;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Purchases\Bill\BillsServices;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\belongsToMany;

class Bill extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use BillsServices;

    protected $fillable = [
        'vendor_id',
        'bill_number',
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
     * Define a many-to-many relationship with Vendor class
     *
     * @return BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Define a many-to-many relationship with IncomeCategory class
     *
     * @return BelongsTo
     */
    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Define a many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items(): belongsToMany
    {
        return $this->belongsToMany(Item::class, 'bill_details')
            ->withPivot([
                'bill_id',
                'item_id',
                'discount_id',
                'item',
                'price',
                'quantity',
                'amount',
                'discount',
                'tax'
            ])
            ->as('details')
            ->withTimestamps();
    }

    /**
     * Define a one-to-one relationship with BillPaymentDetail class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentDetail(): HasOne
    {
        return $this->hasOne(BillPaymentDetail::class);
    }

    /**
     * Define many-to-one relationship with BillHistory class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(BillHistory::class);
    }
}
