<?php

namespace App\Models;

use App\Traits\InventoryManagement\Stock\StocksServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use StocksServices;

    protected $fillable = [
        'supplier_id',
        'warehouse_id',
        'in_stock',
        'incoming_stock',
        'stock_in',
        'stock_out',
        'bad_stock'
    ];

    /**
     * Define an inverse one-to-one or many relationship with Item class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
