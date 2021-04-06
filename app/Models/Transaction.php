<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Banking\Transaction\TransactionsServices;

class Transaction extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use TransactionsServices;
    
    protected $fillable = [
        'payment_transaction_id',
        'account_id',
        'category_id',
        'type',
        'amount',
        'deposit',
        'withdrawal',
        'description',
        'contact',
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
     * Define an inverse one-to-many relationship with Category class
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
