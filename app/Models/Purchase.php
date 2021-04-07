<?php

namespace App\Models;

use App\Traits\Purchases\Purchase\PurchasesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PurchasesServices;

    protected $fillable = [
        'number',
        'account_id',
        'vendor_id',
        'expense_category_id',
        'payment_method_id',
        'currency_id',
        'date',
        'amount',
        'description',
        'recurring',
        'reference',
        'file',
    ];
}
