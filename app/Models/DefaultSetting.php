<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    use HasFactory;

    protected $fillable =  [
        'account_id',
        'currency_id',
        'income_category_id',
        'expense_category_id',
        'tax_id',
        'payment_method_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
