<?php

namespace App\Models;

use App\Traits\InventoryManagement\Warehouse\WarehousesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use WarehousesServices;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'default_warehouse',
        'enabled'
    ];
    
    /**
     * Define a many-to-many relationship with Stock class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class);
    }
}
