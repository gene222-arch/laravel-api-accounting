<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'email',
        'phone',
        'stage',
        'mobile',
        'website',
        'fax_number',
        'source',
        'address',
        'born_at'
    ];

    protected $hidden = [
        'updated_at'
    ];
    
    /**
     * getCreatedAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * getBornAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getBornAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
