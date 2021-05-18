<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Contribution;
use App\Models\SalaryBenefit;
use App\Models\SalaryDeduction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HumanResource\Payroll\Payroll\PayrollsServices;

class Payroll extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use PayrollsServices;

    protected $fillable = [
        'name',
        'account_id',
        'expense_category_id',
        'payment_method_id',
        'from_date',
        'to_date',
        'payment_date',
        'status'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    /**
     * getFromDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getFromDateAttribute($value): string
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * getToDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getToDateAttribute($value): string
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * getPaymentDateAttribute
     *
     * @param  mixed $value
     * @return string
     */
    public function getPaymentDateAttribute($value): string
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Define a many-to-many relationship with Employee class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function details(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class)
            ->withPivot([
                'salary',
                'benefit',
                'deduction',
                'total_amount'
            ]);
    }
    
    /**
     * Define a many-to-many relationship with Tax class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employeeTaxes(): BelongsToMany
    {   
        return $this->belongsToMany(Tax::class)
            ->withPivot([
                'employee_id',
                'amount'
            ]);
    }

    /**
     * Define a many-to-many relationship with SalaryBenefit class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employeeBenefits(): BelongsToMany
    {   
        return $this->belongsToMany(SalaryBenefit::class)
            ->withPivot([
                'employee_id',
                'amount'
            ]);
    }

    /**
     * Define a many-to-many relationship with Contribution class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employeeContributions(): BelongsToMany
    {   
        return $this->belongsToMany(Contribution::class, 'payroll_contribution')
            ->withPivot([
                'employee_id',
                'amount'
            ]);
    }

    /**
     * Define a one-to-one relationship with PayCalendar class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payCalendar(): BelongsTo
    {   
        return $this->belongsTo(PayCalendar::class);
    }
}
