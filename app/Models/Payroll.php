<?php

namespace App\Models;

use App\Models\Tax;
use App\Models\SalaryBenefit;
use App\Models\SalaryDeduction;
use Illuminate\Database\Eloquent\Model;
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

}
