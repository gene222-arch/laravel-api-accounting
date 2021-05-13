<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'status',
        'description'
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
}
