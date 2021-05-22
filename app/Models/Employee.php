<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Contribution;
use App\Models\SalaryBenefit;
use App\Traits\Upload\UploadServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HumanResource\Employee\EmployeesServices;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Define a many-to-many relationship with SalaryBenefit class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function benefits(): BelongsToMany
    {
        return $this->belongsToMany(SalaryBenefit::class, 'payroll_salary_benefit')
            ->withPivot([
                'payroll_id',
                'amount'
            ]);
    }

    /**
     * Define a many-to-many relationship with Contribution class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Contribution::class, 'payroll_contribution')
            ->withPivot([
                'payroll_id',
                'amount'
            ]);
    }

    /**
     * Define a one-to-one relationship with Salary class
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function salary(): HasOne
    {
        return $this->hasOne(Salary::class);
    }

    /**
     * Define a many-to-many relationship with Payroll class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrolls(): BelongsToMany
    {
        return $this->belongsToMany(Payroll::class)
            ->withPivot([
                'salary',
                'benefit',
                'deduction',
                'total_amount'
            ]);
    }
    
    /**
     * Define a one-to-one relationship with Role class
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo 
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Define a many-to-many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class, 'payroll_tax')
            ->withPivot([
                'payroll_id',
                'amount'
            ]);
    }
}
