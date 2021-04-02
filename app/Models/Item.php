<?php

namespace App\Models;

use App\Traits\Item\ItemServices;
use App\Traits\Upload\UploadServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use ItemServices, UploadServices;

    protected $fillable = [
        'category_id',
        'sku',
        'barcode',
        'name',
        'description',
        'price',
        'cost',
        'sold_by',
        'is_for_sale',
        'image'
    ];

    
    /**
     * Define a many-to-many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(
            Tax::class, 
            'item_tax', 
            'item_id', 
            'tax_id');
    }
}
