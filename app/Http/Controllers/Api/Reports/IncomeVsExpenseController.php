<?php

namespace App\Http\Controllers\Api\Reports;

use Carbon\Carbon;
use App\Models\Company;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\IncomeVsExpenseServices;

class IncomeVsExpenseController extends Controller
{
    use ApiResponser, IncomeVsExpenseServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Income vs Expense Summary']);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {   
        setSqlModeEmpty();

        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year', date('Y'));

        $incomeVsExpenseSummary = $this->incomeVsExpenseSummary($dateFrom, $dateTo, $year);

        return $this->success($incomeVsExpenseSummary);
    }
}
