<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Banking\BankAccountReconciliation\BankAccountReconciliationsServices;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccountReconciliation extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use BankAccountReconciliationsServices;

    protected $fillable = [
        'account_id',
        'started_at',
        'ended_at',
        'closing_balance',
        'cleared_amount',
        'difference',
        'status'
    ];
    
    /**
     * Define an inverse one-to-one or many relationship with Account class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
