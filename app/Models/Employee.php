<?php

namespace App\Models;

use App\Traits\HumanResource\Employee\EmployeesServices;
use App\Traits\Upload\UploadServices;
use Carbon\Carbon;
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
        'role_id',
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'gender',
        'phone',
        'address',
        'enabled'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getBirthDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getBirthDateAttribute($value): string 
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

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
