<?php

namespace App\Models;

use App\Models\ChartOfAccountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    protected $fillable = [
        'chart_of_account_type_id',
        'name',
        'code',
        'description',
        'enabled'
    ];
    
    /**
     * Define an inverse one-to-many relationship with ChartOfAccountType class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccountType::class);
    }
}
