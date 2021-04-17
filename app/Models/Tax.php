<?php

namespace App\Models;

use App\Models\TaxSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'type'
    ];

    /**
     * Define an inverse many-to-many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    /**
     * Define a one-to-many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxSummary(): HasMany
    {
        return $this->hasMany(TaxSummary::class);
    }
}
