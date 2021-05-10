<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sales\Revenue\RevenuesServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Revenue extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use RevenuesServices;

    protected $fillable = [
        'number',
        'account_id',
        'customer_id',
        'income_category_id',
        'payment_method_id',
        'currency_id',
        'date',
        'amount',
        'description',
        'recurring',
        'reference',
        'file'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getDateAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Define an inverse one-to-many relationship with Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
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
     * Define an inverse one-to-many relationship with Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    
    /**
     * Define an inverse one-to-many relationship with IncomeCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }
    
    /**
     * Define an inverse one-to-many relationship with PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Define a many-to-many relationship with PaymentMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }
}
