<?php

namespace App\Models;

use App\Traits\Item\ItemServices;
use App\Traits\Upload\UploadServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
