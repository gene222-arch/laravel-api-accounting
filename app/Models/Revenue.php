<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Sales\Revenue\RevenuesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
