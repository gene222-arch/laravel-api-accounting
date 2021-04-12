<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'enabled'
    ];
    
    /**
     * Define a one-to-many relationship with InvoiceDetail class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
