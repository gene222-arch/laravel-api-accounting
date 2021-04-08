<?php

namespace App\Models;

use App\Traits\HumanResource\Employee\EmployeesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use EmployeesServices;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'gender',
        'phone',
        'address',
        'enabled'
    ];
    
    /**
     * Define a one-to-one relationship with Salary
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function salary(): HasOne
    {
        return $this->hasOne(Salary::class);
    }
}
