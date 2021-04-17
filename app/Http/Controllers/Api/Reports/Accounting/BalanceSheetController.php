<?php

namespace App\Http\Controllers\Api\Reports\Accounting;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\Accounting\BalanceSheetServices;

class BalanceSheetController extends Controller
{
    use ApiResponser, BalanceSheetServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Balance Sheet']);
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
        $filter = request()->get('filter');

        $balanceSheet = $this->balanceSheet($dateFrom, $dateTo, $year, $filter);

        return $this->success($balanceSheet);
    }
}
