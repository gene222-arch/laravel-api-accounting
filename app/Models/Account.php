<?php

namespace App\Models;

use App\Traits\Banking\Account\AccountsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use AccountsServices;

    protected $fillable = [
        'currency_id',
        'name',
        'number',
        'opening_balance',
        'balance',
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
