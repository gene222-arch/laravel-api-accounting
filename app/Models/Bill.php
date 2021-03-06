<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Currency;
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
        'currency_id',
        'expense_category_id',
        'vendor_id',
        'bill_number',
        'order_no',
        'date',
        'due_date',
        'status',
        'recurring'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $timeFormat = 'Y-m-d';
    
    /**
     * getDueDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getDueDateAttribute($value): string 
    {
        return Carbon::parse($value)->format($this->timeFormat);
    }

    /**
     * getDueDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getDateAttribute($value): string 
    {
        return Carbon::parse($value)->format($this->timeFormat);
    }

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
     * Define a one-to-many relationship with Vendor class
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
                'discount_id',
                'tax_id',
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

    /**
     * transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'model_id')
            ->where('model_type', get_class($this));
    }

}
