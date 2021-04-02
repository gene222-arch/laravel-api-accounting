<?php

namespace App\Models;

use App\Traits\Item\TaxServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use TaxServices;


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
