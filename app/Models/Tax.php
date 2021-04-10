<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Settings\Tax\TaxesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use TaxesServices;


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
}
