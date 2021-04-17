<?php

namespace App\Http\Controllers\Api\Reports\Accounting;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Reports\Accounting\GeneralLedgerServices;

class GeneralLedgerController extends Controller
{
    use ApiResponser, GeneralLedgerServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View General Ledger']);
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
        $accountName = request()->get('accountName');

        $generalLedger = $this->generalLedger($dateFrom, $dateTo, $year, $accountName);

        return $this->success($generalLedger);
    }
}
