<?php

namespace App\Http\Controllers\Api\Dashboard\Payroll;

use Carbon\Carbon;
use App\Models\Company;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Dashboard\Payroll\PayrollDashboardServices;

class PayrollDashboardController extends Controller
{
    use ApiResponser, PayrollDashboardServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Payroll Dashboard']);
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year');

        $dashboard = $this->dashboard($dateFrom, $dateTo, $year);

        return $this->success($dashboard);
    }
}
