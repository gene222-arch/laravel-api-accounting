<?php

namespace App\Http\Controllers\Api\Reports;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\ExpenseSummaryServices;

class ExpenseSummaryController extends Controller
{
    use ApiResponser, ExpenseSummaryServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Income Summary']);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {   
        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year', date('Y'));

        $incomeSummary = $this->expenseSummary($dateFrom, $dateTo, $year);

        return $this->success($incomeSummary);
    }
}
