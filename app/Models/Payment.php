<?php

namespace App\Models;

use App\Traits\Purchases\Payment\PaymentsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PaymentsServices;

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
