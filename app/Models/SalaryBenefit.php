<?php

namespace App\Models;

use App\Traits\HumanResource\Payroll\SalaryBenefit\SalaryBenefitsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryBenefit extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use SalaryBenefitsServices;

    protected $fillable = [
        'type',
        'amount',
        'enabled'
    ];
}
