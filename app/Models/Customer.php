<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Revenue;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    /** Libraries or Built-in */
    use HasFactory, Notifiable;

    protected $fillable = [
        'currency_id',
        'name',
        'email',
        'tax_number',
        'phone',
        'website',
        'address',
        'reference',
        'enabled'
    ];

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
     * Define a one-to-many relationship with Invoice class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Define a one-to-many relationship with Revenue class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }
}
