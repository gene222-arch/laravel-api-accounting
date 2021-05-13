<?php

namespace App\Models;

use App\Traits\HumanResource\Payroll\PayCalendar\PayCalendarsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PayCalendar extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PayCalendarsServices;

    protected $fillable = [
        'name',
        'type',
        'pay_day_mode'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * Define a many-to-many relationship with Employee class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
}
