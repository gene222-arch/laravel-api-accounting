<?php

namespace App\Http\Controllers\Api\Dashboard\Main;

use Illuminate\Http\Request;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Currency;
use App\Traits\Dashboard\Main\MainDashboardServices;
use Carbon\Carbon;

class MainDashboardController extends Controller
{
    use ApiResponser, MainDashboardServices;

    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:View Main Dashboard']);
    }

    /**
     * Display a general list of main dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $dateFrom = request()->get('dateFrom', Company::first()->created_at);
        $dateTo = request()->get('dateTo', Carbon::now());
        $year = request()->get('year', date('Y'));

        $dashboard = $this->dashboardData($dateFrom, $dateTo, $year);

        return $this->success($dashboard);
    }
}
