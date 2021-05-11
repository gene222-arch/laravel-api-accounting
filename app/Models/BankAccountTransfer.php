<?php

namespace App\Models;

use App\Traits\Banking\BankAccountTransfer\BankAccountTransfersServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccountTransfer extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use BankAccountTransfersServices;

    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'payment_method_id',
        'amount',
        'transferred_at',
        'description',
        'reference'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
        
    /**
     * getTransferredAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getTransferredAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Define a one-to-many relationship with Account class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    /**
     * Define a one-to-many relationship with Account class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    /**
     * Define a one-to-many relationship with PaymentMethod class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
