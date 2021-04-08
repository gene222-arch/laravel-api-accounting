<?php

namespace App\Models;

use App\Traits\HumanResource\Payroll\SalaryDeduction\SalaryDeductionsServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDeduction extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use SalaryDeductionsServices;

    protected $fillable = [
        'type',
        'rate',
        'enabled'
    ];
}
