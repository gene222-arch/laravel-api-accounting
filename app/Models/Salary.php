<?php

namespace App\Models;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'currency_id',
        'amount',
        'tax_number',
        'bank_account_number',
        'hired_at'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * getHiredAtAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getHiredAtAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    
    /**
     * Define an inverse one-to-one relationship with Employee class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
