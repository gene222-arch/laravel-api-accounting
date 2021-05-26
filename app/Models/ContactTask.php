<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'started_at',
        'time_started',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getStartedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getStartedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * Define an inverse one-to-one or many relationship Contact Task class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
