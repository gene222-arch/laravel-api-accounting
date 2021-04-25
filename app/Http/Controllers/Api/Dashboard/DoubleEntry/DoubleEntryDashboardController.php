<?php

namespace App\Http\Controllers\Api\Dashboard\DoubleEntry;

use Carbon\Carbon;
use App\Models\Company;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Traits\Dashboard\DoubleEntry\DoubleEntryDashboardServices;

class DoubleEntryDashboardController extends Controller
{
    use ApiResponser, DoubleEntryDashboardServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Double Entry Dashboard']);
    }

    /**
     * Display a general list of double entry dashboard data.
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
