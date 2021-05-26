<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 
        'time',
        'log',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getDateAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * Define an inverse one-to-one or many relationship with Contact class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
