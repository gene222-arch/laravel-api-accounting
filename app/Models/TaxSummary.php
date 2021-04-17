<?php

namespace App\Models;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'tax_id',
        'amount'
    ];

    public $timestamps = false;
        
    /**
     * Define an inverse one-to-one or many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxes(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
