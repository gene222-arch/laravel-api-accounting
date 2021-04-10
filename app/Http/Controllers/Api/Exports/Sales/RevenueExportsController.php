<?php

namespace App\Http\Controllers\Api\Exports\Sales;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Exports\Sales\RevenueExport;
use App\Http\Controllers\Controller;
use App\Models\Revenue;

class RevenueExportsController extends Controller
{
    private RevenueExport $revenue;
    
    public function __construct(RevenueExport $revenue)
    {
        $this->revenue = $revenue;
    }
    
    /**
     * Export revenues to csv
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function csv()
    {
        $fileName = 'revenue-' . Carbon::now()->toDateTimeString() . '-.csv';

        return $this->revenue
            ->download($fileName, Excel::CSV, [
                'Content-Type' => 'text/xlsx'
            ]);
    }

    /**
     * Export revenues to excel
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excel()
    {
        $fileName = 'revenue-' . Carbon::now()->toDateTimeString() . '-.xlsx';

        return $this->revenue
            ->download($fileName, Excel::XLSX, [
                'Content-Type' => 'text/xlsx'
            ]);
    }
}
