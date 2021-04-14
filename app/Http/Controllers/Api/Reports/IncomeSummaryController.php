<?php

namespace App\Http\Controllers\Api\Reports;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Reports\IncomeSummaryServices;

class IncomeSummaryController extends Controller
{
    use ApiResponser, IncomeSummaryServices;

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
        setSqlModeEmpty();

        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year', date('Y'));

        $incomeSummary = $this->incomeSummary($dateFrom, $dateTo, $year);

        return $this->success($incomeSummary);
    }
}
