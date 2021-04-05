<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Purchase\Bill\BillsServices;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\belongsToMany;

class Bill extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use BillsServices;

    protected $fillable = [
        'vendor_id',
        'bill_number',
        'order_no',
        'date',
        'due_date',
        'status'
    ];

    /**
     * Define a many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function items(): belongsToMany
    {
        return $this->belongsToMany(Item::class, 'bill_details')
            ->withPivot([
                'bill_id',
                'item_id',
                'discount_id',
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
     * Define many-to-one relationship with BillPayment class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(BillPayment::class);
    }
}
