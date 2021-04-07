<?php

namespace App\Models;

use App\Traits\Item\Item\ItemsServices;
use App\Traits\Upload\UploadServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use ItemsServices, UploadServices;

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
     * Define a one-to-many relationship with InvoiceDetail class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /**
     * Define a one-to-one relationship with Stock class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * Define a many-to-many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class);
    }
}
