<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
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
        'image',
        'enabled',
    ];
    
    /**
     * Define an inverse one-to-one or many relationship with Currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
