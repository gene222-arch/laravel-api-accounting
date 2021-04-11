<?php

namespace App\Models;

use App\Models\Account;
use App\Models\PaymentMethod;
use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Banking\Transaction\HasTransaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use HasTransaction;
    
    protected $fillable = [
        'model_type',
        'model_id',
        'number',
        'account_id',
        'income_category_id',
        'expense_category_id',
        'payment_method_id',
        'category',
        'type',
        'amount',
        'deposit',
        'withdrawal',
        'description',
        'contact'
    ];

    /**
     * Define an inverse one-to-many relationship with Account class
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Define an inverse one-to-many relationship with IncomeCategory class
     *
     * @return BelongsTo
     */
    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class);
    }

    /**
     * Define an inverse one-to-many relationship with ExpenseCategory class
     *
     * @return BelongsTo
     */
    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Define an inverse one-to-many relationship with PaymentMethod class
     *
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
