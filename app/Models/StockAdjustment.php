<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\InventoryManagement\Stock\StockAdjustmentsServices;

class StockAdjustment extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use StockAdjustmentsServices;

    protected $fillable = [
        'stock_adjustment_number',
        'reason'
    ];

    public const RECEIVED_ITEMS = 'Received items';
    public const LOSS_ITEMS = 'Loss items';
    public const DAMAGED_ITEMS = 'Damaged items';
    public const INVENTORY_COUNT = 'Inventory count';
    
    /**
     * Array list of adjustment reasons
     *
     * @return array
     */
    public static function adjustmentReasons(): array
    {
        return [
            self::RECEIVED_ITEMS,
            self::LOSS_ITEMS,
            self::DAMAGED_ITEMS,
            self::INVENTORY_COUNT
        ];
    }
    
    /**
     * Define a many-to-many relationship with Stock class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function details(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'stock_adjustment_details')
            ->withPivot([
                'item',
                'book_quantity',
                'quantity',
                'physical_quantity',
                'unit_price',
                'amount'
            ]);
    }

}
