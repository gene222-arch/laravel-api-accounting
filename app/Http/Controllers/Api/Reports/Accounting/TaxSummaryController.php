<?php

namespace App\Http\Controllers\Api\Reports\Accounting;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\Accounting\TaxSummaryServices;

class TaxSummaryController extends Controller
{
    use ApiResponser, TaxSummaryServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Tax Summary']);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {   
        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year', date('Y'));

        $profitAndLoss = $this->taxSummary($dateFrom, $dateTo, $year);

        return $this->success($profitAndLoss);
    }
}
