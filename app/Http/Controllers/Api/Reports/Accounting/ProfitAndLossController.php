<?php

namespace App\Http\Controllers\Api\Reports\Accounting;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\Accounting\ProfitAndLossServices;

class ProfitAndLossController extends Controller
{
    use ApiResponser, ProfitAndLossServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Profit and Loss']);
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

        $profitAndLoss = $this->profitAndLoss($dateFrom, $dateTo, $year);

        return $this->success($profitAndLoss);
    }
}
