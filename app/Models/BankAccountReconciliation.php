<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Banking\BankAccountReconciliation\BankAccountReconciliationsServices;
use Carbon\Carbon;
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
     * getStartedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getStartedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * getEndedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getEndedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * getUpdatedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

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
