<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Vendor;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Purchases\Payment\PaymentsServices;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PaymentsServices;

    protected $fillable = [
        'number',
        'account_id',
        'vendor_id',
        'expense_category_id',
        'payment_method_id',
        'currency_id',
        'date',
        'amount',
        'description',
        'recurring',
        'reference',
        'file',
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
     * Define a many-to-many relationship with Currency class
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    
    /**
     * Define an inverse one-to-many relationship with Vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Define an inverse one-to-many relationship with IncomeCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
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
    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class);
    }
}
