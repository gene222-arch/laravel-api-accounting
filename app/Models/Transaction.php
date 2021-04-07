<?php

namespace App\Models;

use App\Models\Account;
use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Banking\Transaction\HasTransaction;

class Transaction extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use HasTransaction;
    
    protected $fillable = [
        'model_type',
        'model_id',
        'account_id',
        'income_category_id',
        'expense_category_id',
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
}
