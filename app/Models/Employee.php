<?php

namespace App\Models;

use App\Traits\HumanResource\Employee\EmployeesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    /** Libraries or Built-in */
    use HasFactory, HasRoles;

    /** Custom */
    use EmployeesServices;

    protected $fillable = [
        'name',
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
