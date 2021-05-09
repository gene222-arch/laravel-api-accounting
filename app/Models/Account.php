<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'currency_id',
        'name',
        'number',
        'opening_balance',
        'balance',
        'bank_name',
        'bank_phone',
        'bank_address',
        'enabled'
    ];
    
    /**
     * Define a one-to-many relationship with Revenue Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }
}
