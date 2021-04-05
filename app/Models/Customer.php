<?php

namespace App\Models;

use App\Models\Revenue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Sales\Customer\CustomersServices;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    /** Libraries or Built-in */
    use HasFactory, Notifiable;

    /** Custom */
    use CustomersServices;

    protected $fillable = [
        'name',
        'email',
        'tax_number',
        'currency',
        'phone',
        'website',
        'address',
        'reference'
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
